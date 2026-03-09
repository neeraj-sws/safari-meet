<?php

namespace App\Livewire\Front\Auth;

use App\Helpers\UserHelper;
use App\Mail\DynamicMail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use App\Rules\ValidPhoneNumber;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class RegisterComponent extends Component
{
    #[Layout('components.layouts.guest_login')]

    public $name, $phone, $email, $password, $password_confirmation, $terms;
    public $showPassword = false;
    public $showConfirmPassword = false;


    public function render()
    {
        return view('livewire.front.auth.register-componet');
    }

    public function register()
    {
        $this->validate([
            'name' => [
                'required',
                'string',
                'max:20',
                'regex:/^[A-Za-z]+(?: [A-Za-z]+)*$/',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        return $fail('The name cannot have leading or trailing spaces.');
                    }
                },
            ],
            'phone' => [
                'required',
                'numeric',
                'digits:10',
                new ValidPhoneNumber(),
                function ($attribute, $value, $fail) {

                    if (substr($value, 0, 1) == '0') {
                        return $fail('The phone number cannot start with 0.');
                    }
                    for ($i = 0; $i <= 9; $i++) {
                        if (preg_match('/^' . str_repeat($i, 5) . '/', $value)) {
                            return $fail('The phone number cannot have 5 or more consecutive identical digits.');
                        }
                    }
                }
            ],
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
            ],
            'terms' => 'accepted',
        ], [
            'name.regex' => 'The name field may only contain letters and single spaces between words.',
            'name.required' => 'The name field is required.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'phone.required' => 'The phone number field is required.',
            'phone.numeric' => 'The phone number must be numeric.',
            'phone.digits' => 'The phone number must be exactly 10 digits.',
            'email.unique' => 'User already exists.',
        ]);

        do {
            $otp = rand(100000, 999999);
        } while (User::where('email_verified_otp', $otp)->exists());

        $IdAddress =  UserHelper::UserIPDetails();

        $user = User::create([
            'name' => ucwords($this->name),
            'username' => UserHelper::generateUsername($this->name),
            'phone_number' => $this->phone,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'agree_t_c' => $this->terms,
            'otp_expires_at' => Carbon::now()->addMinutes(10),
            'email_verified_otp' => $otp,
        ]);

        $slug = base64_encode($user->email);

        $data = [
            'username' => $user->name,
            'otp' => $user->email_verified_otp,
            'year' => date('Y'),
        ];

        $parsed = UserHelper::parseTemplate('AGENTEMAILVERIFY', $data);
<<<<<<< HEAD
        // Mail::to($this->email)->queue(
        //     new DynamicMail($parsed['subject'], $parsed['body'])
        // );

         dispatch(function () use ($user, $parsed) {
            Mail::to($this->email)->send( 
                new DynamicMail($parsed['subject'], $parsed['body'])
            );
        })->afterResponse();
=======
        Mail::to($this->email)->queue(
            new DynamicMail($parsed['subject'], $parsed['body'])
        );
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b

        log_activity('auth.signup', [
            'actor_type' => class_basename($user),
            'actor_id' => $user->id,
            'actor_identifier' => $user->email,
            'guard' => 'web',
            'user_id' => $user->id,
            'email' => $user->email ?? null,
            'message' => 'User signed up with email ' . $user->email ?? null
        ]);

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Details Added Successfully']);
        return redirect()->route('email_verify', $slug);
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

    public function loginWithGoogle()
    {
        session(['social_role' => 'user']);
        return redirect()->away(Socialite::driver('google')->stateless()->redirect()->getTargetUrl());
    }

    public function loginWithFacebook()
    {
        session(['social_role' => 'user']);
        return redirect()->away(Socialite::driver('facebook')->stateless()->redirect()->getTargetUrl());
    }


    public function getCanSubmitProperty()
    {
        return collect($this->passwordRules)->every(fn($v) => $v) &&
            collect($this->confirmPasswordRules)->every(fn($v) => $v) &&
            !empty($this->name) &&
            !empty($this->phone) &&
            !empty($this->email);
        // $this->terms;
    }
}
