<?php

namespace App\Livewire\Front\Auth;

use App\Helpers\SettingHelper;
use App\Helpers\UserHelper;
use App\Mail\DynamicMail;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Rules\ValidPhoneNumber;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

#[Layout('components.layouts.guest_login')]
class AgentRegistration extends Component
{
    public $agency_name, $license_number, $contact_person, $phone, $email, $website, $location, $experience, $terms = false, $countries = [], $country, $states = [], $state, $cities = [], $city, $password, $password_confirmation;
    public $showPassword = false;
    public $showConfirmPassword = false;


    public function mount()
    {
        $this->countries = Country::orderByRaw("CASE WHEN name = 'India' THEN 0 ELSE 1 END")
            ->orderBy('name', 'asc')
            ->pluck('name', 'country_id')->toArray();
    }

    public function render()
    {
        return view('livewire.front.auth.agent-registration');
    }

    public function register()
    {
        $this->validate([
            'agency_name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                'regex:/^[A-Za-z]+(?: [A-Za-z]+)*$/',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        return $fail('Agency name cannot have leading or trailing spaces.');
                    }
                },
            ],
            'contact_person' => [
                'required',
                'string',
                'min:3',
                'max:255',
                'regex:/^[A-Za-z]+(?: [A-Za-z]+)*$/',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        return $fail('Contact person name cannot have leading or trailing spaces.');
                    }
                },
            ],
            'phone' => [
                'required',
                'regex:/^[0-9]{10}$/',
                'unique:users,phone_number',
                new ValidPhoneNumber(),
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                'unique:users,email',
            ],
            'website' => [
                'nullable',
                'string',
                'url',
                'max:255',
                'regex:/^https?:\/\/(www\.)?[a-z0-9\-]+(\.[a-z]{2,63})+([\/\w\-.~:?#[\]@!$&\'()*+,;=]*)?$/i',
                'not_regex:/^https?:\/\/(localhost|127\.0\.0\.1)/',
                function ($attribute, $value, $fail) {
                    // Custom TLD check (common ones only, or use public suffix list)
                    $allowedTlds = ['com', 'net', 'org', 'edu', 'gov', 'io', 'co', 'in', 'info', 'biz', 'me'];
                    $host = parse_url($value, PHP_URL_HOST);
                    $tld = strtolower(substr(strrchr($host, '.'), 1));

                    if (!in_array($tld, $allowedTlds)) {
                        $fail('The website must have a valid top-level domain (like .com, .net, etc).');
                    }
                },
            ],

            'country' => ['required'],
            'state' => ['required'],
            'city' => ['required'],
            'experience' => [
                'required',
                'integer',
                'min:0',
            ],
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
            ],
            'terms' => ['accepted'],
        ], [

            'agency_name.required' => 'Agency name is required.',
            'agency_name.string' => 'Agency name must be a string.',
            'agency_name.min' => 'Agency name must be at least 3 characters.',
            'agency_name.max' => 'Agency name cannot exceed 255 characters.',
            'agency_name.regex' => 'Agency name can only contain letters and single spaces between words.',

            'contact_person.required' => 'Contact person is required.',
            'contact_person.string' => 'Contact person must be a string.',
            'contact_person.min' => 'Contact person must be at least 3 characters.',
            'contact_person.max' => 'Contact person cannot exceed 255 characters.',
            'contact_person.regex' => 'Contact person can only contain letters and single spaces between words.',

            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Phone number must be exactly 10 digits.',
            'phone.unique' => 'This phone number is already taken.',

            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',

            'website.url' => 'Website must be a valid URL.',
            'website.regex' => 'The website format is invalid.',
            'website.not_regex' => 'Localhost or internal IPs are not allowed for website.',


            'country.required' => 'Country is required.',
            'state.required' => 'State is required.',
            'city.required' => 'City is required.',

            'experience.required' => 'Experience is required.',
            'experience.integer' => 'Experience must be a number.',
            'experience.min' => 'Experience cannot be negative.',

            'terms.accepted' => 'You must accept the terms and conditions.',
        ]);


        do {
            $otp = rand(100000, 999999);
        } while (User::where('email_verified_otp', $otp)->exists());

        $IdAddress =  UserHelper::UserIPDetails();

        $user =  User::create([
            'agency_name' => ucwords($this->agency_name),
            'username' => UserHelper::generateUsername($this->contact_person),
            'license_number' => $this->license_number,
            'contact_person' => $this->contact_person,
            'name' => ucwords($this->contact_person),
            'phone_number' => $this->phone,
            'email' => $this->email,
            'website_url' => $this->website,
            'country_id' => $this->country,
            'state_id' => $this->state,
            'city_id' => $this->city,
            'experience_year' => $this->experience,
            'otp_expires_at' => Carbon::now()->addMinutes(10),
            'email_verified_otp' => $otp,
            'user_type' => 1,
            'ip_address' => $IdAddress['ip_address'],
            'browser' => $IdAddress['browser'],
            'os' => $IdAddress['os'],
            'device' => $IdAddress['is_mobile'] ? 'Mobile' : 'Desktop',
            'password' => Hash::make($this->password),
        ]);
        $slug = base64_encode($user->email);

        $data = [
            'username' => $this->contact_person,
            'otp' => $user->email_verified_otp,
            'year' => date('Y'),
        ];

        $parsed = UserHelper::parseTemplate('AGENTEMAILVERIFY', $data);
        // Mail::to($this->email)->queue(
        //     new DynamicMail($parsed['subject'], $parsed['body'])
        // );
        dispatch(function () use ($user, $parsed) {
            Mail::to($user->email)->send(
                new DynamicMail($parsed['subject'], $parsed['body'])
            );
        })->afterResponse();

        createNotification(
            16,
            1,
            'App\Models\Admin',
            $user->id,
            get_class($user),
            [
                'name' => 'Agent',
                'email' => $user->email,
                'message' => 'Agent signed up with email ' . $user->email ?? null,
                'safari_url' => route('admin.travel_agent')
            ],
            'system'
        );

        log_activity('auth.signup', [
            'actor_type' => class_basename($user),
            'actor_id' => $user->id,
            'actor_identifier' => $user->email,
            'guard' => 'web',
            'user_id' => $user->id,
            'email' => $user->email ?? null,
            'message' => 'Agent signed up with email ' . $user->email ?? null
        ]);

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Details Added Successfully']);
        return redirect()->route('email_verify', $slug);
    }

    public function updatedCountry()
    {
        $this->states = State::where('country_id', $this->country)->pluck('name', 'state_id')->toArray();
    }

    public function updatedState()
    {
        $this->cities = City::where('state_id', $this->state)->pluck('name', 'city_id')->toArray();
    }

    public function getPasswordRulesProperty()
    {
        $password = $this->password ?? '';

        return [
            'lower' => preg_match('/[a-z]/', $password),
            'upper' => preg_match('/[A-Z]/', $password),
            'number' => preg_match('/[0-9]/', $password),
            'special' => preg_match('/[\W_]/', $password),
            'length' => strlen($password) >= 6,
        ];
    }

    public function isPasswordValid()
    {
        $rules = $this->passwordRules;
        return $rules['lower'] && $rules['upper'] && $rules['number'] && $rules['special'] && $rules['length'];
    }

    public function loginWithGoogle()
    {
        session(['social_role' => 'agent']);
        return redirect()->away(Socialite::driver('google')->stateless()->redirect()->getTargetUrl());
    }

    public function loginWithFacebook()
    {
        session(['social_role' => 'agent']);
        return redirect()->away(Socialite::driver('facebook')->stateless()->redirect()->getTargetUrl());
    }


    public function getConfirmPasswordRulesProperty()
    {
        $password_confirmation = $this->password_confirmation ?? '';

        return [
            'lower' => preg_match('/[a-z]/', $password_confirmation),
            'upper' => preg_match('/[A-Z]/', $password_confirmation),
            'number' => preg_match('/[0-9]/', $password_confirmation),
            'special' => preg_match('/[\W_]/', $password_confirmation),
            'length' => strlen($password_confirmation) >= 6,
        ];
    }

    public function isConfirmPasswordValid()
    {
        $rules = $this->confirmPasswordRules;
        return $rules['lower'] && $rules['upper'] && $rules['number'] && $rules['special'] && $rules['length'];
    }
}
