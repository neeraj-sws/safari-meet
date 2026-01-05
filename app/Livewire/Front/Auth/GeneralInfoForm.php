<?php

namespace App\Livewire\Front\Auth;

use App\Helpers\ImageHelper;
use App\Helpers\ImageUploadHelper;
use App\Models\{User, State, Country, City};
use Illuminate\Support\Facades\Auth;
use App\Rules\ValidPhoneNumber;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class GeneralInfoForm extends Component
{
    use WithFileUploads;

    public $name = '';
    public $dob = '';
    public $gender = '';
    public $profileDesc = '';
    public $about = '';
    public $facebook = '';
    public $instagram = '';
    public $youtube = '';
    public $twitter = '', $user, $profile_photo, $coverImage, $activeTab = 'information', $countries = [], $country, $states = [], $state, $cities = [], $city;
    public $agency_name, $contact_person, $license_number, $website_url, $phone_number, $uploadedprofile;


    public function mount()
    {
        $this->user = User::find(Auth::guard('web')->user()->id);
        $this->name = $this->user->name;
        $this->dob = $this->user->dob;
        $this->gender = $this->user->gender;
        $this->profileDesc = $this->user->short_title;
        $this->about = $this->user->short_description;
        $this->facebook = $this->user->facebook;
        $this->instagram = $this->user->instagram;
        $this->youtube = $this->user->youtube;
        $this->twitter = $this->user->twitter;
        $this->country = $this->user->country_id;
        $this->state = $this->user->state_id;
        $this->city = $this->user->city_id;
        $this->agency_name = $this->user->agency_name;
        $this->license_number = $this->user->license_number;
        $this->contact_person = $this->user->contact_person;
        $this->website_url = $this->user->website_url;
        $this->phone_number = $this->user->phone_number;
        $this->uploadedprofile = $this->user->coverImage;
        $this->countries = Country::orderByRaw("CASE WHEN name = 'India' THEN 0 ELSE 1 END")
            ->orderBy('name', 'asc')
            ->pluck('name', 'country_id')->toArray();
        $this->updatedCountry();
        $this->updatedState();
    }

    public function render()
    {
        return view('livewire.front.auth.general-info-form');
    }


    public function save()
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
                    if (preg_match('/\s{2,}/', $value)) {
                        return $fail('The name cannot have consecutive spaces.');
                    }
                },
            ],
            'dob' => [
                'nullable',
                'date_format:Y-m-d',
                function ($attribute, $value, $fail) {
                    if ($value && strtotime($value) > time()) {
                        return $fail('The date of birth cannot be in the future.');
                    }
                },
            ],
            'gender' => 'nullable|in:male,female,other',
            'profileDesc' => 'nullable|string|max:500',
            'about' => 'nullable|string|max:1000',
            'facebook' => [
                'nullable',
                'string',
                'url',
                'max:255',
                'regex:/^https?:\/\/(www\.)?[a-z0-9\-]+(\.[a-z]{2,63})+([\/\w\-.~:?#[\]@!$&\'()*+,;=]*)?$/i',
                'not_regex:/^https?:\/\/(localhost|127\.0\.0\.1)/',
                function ($attribute, $value, $fail) {

                    $allowedTlds = ['com', 'net', 'org', 'edu', 'gov', 'io', 'co', 'in', 'info', 'biz', 'me'];
                    $host = parse_url($value, PHP_URL_HOST);
                    $tld = strtolower(substr(strrchr($host, '.'), 1));
                    if (!in_array($tld, $allowedTlds)) {
                        return $fail('The Facebook URL must have a valid top-level domain (e.g., .com, .net, etc).');
                    }
                },
            ],
            'instagram' => [
                'nullable',
                'string',
                'url',
                'max:255',
                'regex:/^https?:\/\/(www\.)?[a-z0-9\-]+(\.[a-z]{2,63})+([\/\w\-.~:?#[\]@!$&\'()*+,;=]*)?$/i',
                'not_regex:/^https?:\/\/(localhost|127\.0\.0\.1)/',
                function ($attribute, $value, $fail) {

                    $allowedTlds = ['com', 'net', 'org', 'edu', 'gov', 'io', 'co', 'in', 'info', 'biz', 'me'];
                    $host = parse_url($value, PHP_URL_HOST);
                    $tld = strtolower(substr(strrchr($host, '.'), 1));
                    if (!in_array($tld, $allowedTlds)) {
                        return $fail('The Instagram URL must have a valid top-level domain (e.g.,.com, .net, etc).');
                    }
                },
            ],
            'youtube' => [
                'nullable',
                'string',
                'url',
                'max:255',
                'regex:/^https?:\/\/(www\.)?[a-z0-9\-]+(\.[a-z]{2,63})+([\/\w\-.~:?#[\]@!$&\'()*+,;=]*)?$/i',
                'not_regex:/^https?:\/\/(localhost|127\.0\.0\.1)/',
                function ($attribute, $value, $fail) {

                    $allowedTlds = ['com', 'net', 'org', 'edu', 'gov', 'io', 'co', 'in', 'info', 'biz', 'me'];
                    $host = parse_url($value, PHP_URL_HOST);
                    $tld = strtolower(substr(strrchr($host, '.'), 1));
                    if (!in_array($tld, $allowedTlds)) {
                        return $fail('The YouTube URL must have a valid top-level domain (e.g.,.com, .net, etc).');
                    }
                },
            ],
            'twitter' => [
                'nullable',
                'string',
                'url',
                'max:255',
                'regex:/^https?:\/\/(www\.)?[a-z0-9\-]+(\.[a-z]{2,63})+([\/\w\-.~:?#[\]@!$&\'()*+,;=]*)?$/i',
                'not_regex:/^https?:\/\/(localhost|127\.0\.0\.1)/',
                function ($attribute, $value, $fail) {

                    $allowedTlds = ['com', 'net', 'org', 'edu', 'gov', 'io', 'co', 'in', 'info', 'biz', 'me'];
                    $host = parse_url($value, PHP_URL_HOST);
                    $tld = strtolower(substr(strrchr($host, '.'), 1));
                    if (!in_array($tld, $allowedTlds)) {
                        return $fail('The X URL must have a valid top-level domain (e.g., .com, .net, etc).');
                    }
                },
            ],
            'country' => [
                'required',
            ],
            'state' => [
                'required',
            ],
            'city' => [
                'required',
            ],
        ], [
            'name.required' => 'Please enter your full name.',
            'name.string' => 'The name must be a valid string.',
            'name.max' => 'The name cannot exceed 20 characters.',
            'name.regex' => 'The name can only contain alphabets and single spaces between words.',
            'dob.date_format' => 'The date of birth must be in the format YYYY-MM-DD.',
            'dob.future' => 'The date of birth cannot be in the future.',
            'gender.in' => 'Please select a valid gender.',


            'facebook.url' => 'The Facebook URL must be a valid URL.',
            'facebook.max' => 'The Facebook URL cannot exceed 255 characters.',
            'facebook.regex' => 'The Facebook URL format is invalid.',
            'facebook.not_regex' => 'The Facebook URL cannot be from localhost or 127.0.0.1.',
            'facebook.tld' => 'The Facebook URL must have a valid top-level domain (e.g., .com, .net).',


            'instagram.url' => 'The Instagram URL must be a valid URL.',
            'instagram.max' => 'The Instagram URL cannot exceed 255 characters.',
            'instagram.regex' => 'The Instagram URL format is invalid.',
            'instagram.not_regex' => 'The Instagram URL cannot be from localhost or 127.0.0.1.',
            'instagram.tld' => 'The Instagram URL must have a valid top-level domain (e.g., .com, .net).',


            'youtube.url' => 'The YouTube URL must be a valid URL.',
            'youtube.max' => 'The YouTube URL cannot exceed 255 characters.',
            'youtube.regex' => 'The YouTube URL format is invalid.',
            'youtube.not_regex' => 'The YouTube URL cannot be from localhost or 127.0.0.1.',
            'youtube.tld' => 'The YouTube URL must have a valid top-level domain (e.g., .com, .net).',


            'twitter.url' => 'The X URL must be a valid URL.',
            'twitter.max' => 'The X URL cannot exceed 255 characters.',
            'twitter.regex' => 'The X URL format is invalid.',
            'twitter.not_regex' => 'The X URL cannot be from localhost or 127.0.0.1.',
            'twitter.tld' => 'The X URL must have a valid top-level domain (e.g., .com, .net).',


            'country.required' => 'Please select your country.',
            'country.exists' => 'Selected country is invalid.',
            'state.required' => 'Please select your state.',
            'state.exists' => 'Selected state is invalid or does not belong to the selected country.',
            'city.required' => 'Please select your city.',
            'city.exists' => 'Selected city is invalid or does not belong to the selected state.',

            'profileDesc.max' => 'Your are field must not be greater than 500 characters.',
        ]);

        if ($this->user->user_type == 1) {
            $this->validate([
                'agency_name' => [
                    'required',
                    'string',
                    'max:20',
                    'regex:/^[A-Za-z]+(?: [A-Za-z]+)*$/',
                    function ($attribute, $value, $fail) {
                        if (trim($value) !== $value) {
                            return $fail('The name cannot have leading or trailing spaces.');
                        }
                        if (preg_match('/\s{2,}/', $value)) {
                            return $fail('The name cannot have consecutive spaces.');
                        }
                    },
                ],
                'license_number' => ['required', 'string', 'min:3'],
                'profile_photo' => ['nullable', 'image', 'max:2048'], // ✅ fixed
                'contact_person' => [
                    'required',
                    'string',
                    'max:20',
                    'regex:/^[A-Za-z]+(?: [A-Za-z]+)*$/',
                    function ($attribute, $value, $fail) {
                        if (trim($value) !== $value) {
                            return $fail('The name cannot have leading or trailing spaces.');
                        }
                        if (preg_match('/\s{2,}/', $value)) {
                            return $fail('The name cannot have consecutive spaces.');
                        }
                    },
                ],
                'phone_number' => ['required', 'digits:10', new ValidPhoneNumber(), Rule::unique('users', 'phone_number')->ignore($this->user->user_id, 'user_id')],
                'website_url' => [
                    'nullable',
                    'string',
                    'url',
                    'max:255',
                    'regex:/^https?:\/\/(www\.)?[a-z0-9\-]+(\.[a-z]{2,63})+([\/\w\-.~:?#[\]@!$&\'()*+,;=]*)?$/i',
                    'not_regex:/^https?:\/\/(localhost|127\.0\.0\.1)/',
                    function ($attribute, $value, $fail) {
                        $allowedTlds = ['com', 'net', 'org', 'edu', 'gov', 'io', 'co', 'in', 'info', 'biz', 'me'];
                        $host = parse_url($value, PHP_URL_HOST);
                        $tld = strtolower(substr(strrchr($host, '.'), 1));

                        if (!in_array($tld, $allowedTlds)) {
                            $fail('The website must have a valid top-level domain (like .com, .net, etc).');
                        }
                    },
                ],
            ]);
        }


        $image = $this->coverImage;
        if (!empty($image)) {
            $path = 'uploads/front/users/coverimage';
            // $origPath = $image->store($path, 'public_root');
            // $avifPath = '';
            // $avifPath = ImageHelper::convertToAvif($origPath, $path);
            ImageUploadHelper::delete($this->uploadedprofile);
            $avifPath = ImageUploadHelper::upload($image, $path);
        } else {
            $avifPath = $this->uploadedprofile;
        }
        $this->user->coverImage = $avifPath;
        $this->user->name = ucwords($this->name);
        $this->user->dob = $this->dob;
        $this->user->gender = $this->gender;
        $this->user->short_title = $this->profileDesc;
        $this->user->short_description = $this->about;
        $this->user->facebook = $this->facebook;
        $this->user->instagram = $this->instagram;
        $this->user->youtube = $this->youtube;
        $this->user->twitter = $this->twitter;

        if ($this->user->user_type == 1) {
            $this->user->agency_name = ucwords($this->agency_name);
            $this->user->license_number = $this->license_number;
            $this->user->contact_person = ucwords($this->contact_person);
            $this->user->phone_number = $this->phone_number;
            $this->user->website_url = $this->website_url;
        } else {
            if ($this->user->status != 2) {
                $this->user->status = 1;
            }
        }
        $this->user->is_profile_complete = '1';
        $this->user->country_id = $this->country;
        $this->user->state_id = $this->state;
        $this->user->city_id = $this->city;

        $this->user->save();

        $title = ($this->user->is_profile_complete == 1) ? 'update.profile' : 'profile.verification';
        $message = ($this->user->is_profile_complete == 1)
            ? 'User ' . $this->user->name . ' has updated the profile.' . 'Profile has been updated successfully for user ' . $this->user->name . ' (' . $this->user->email . ').'
            : 'Profile has been updated and verification completed for user ' . $this->user->name . ' (' . $this->user->email . ').';

        log_activity($title, [
            'user_id' => $this->user->id,
            'email' => $this->user->email ?? null,
            'message' => $message
        ]);

        $this->dispatch('profileUpdated');

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => 'Profile updated successfully.',
        ]);
    }

    public function updatedCountry()
    {
        $this->states = State::where('country_id', $this->country)->pluck('name', 'state_id')->toArray();
    }

    public function updatedState()
    {
        $this->cities = City::where('state_id', $this->state)->pluck('name', 'city_id')->toArray();
    }
}
