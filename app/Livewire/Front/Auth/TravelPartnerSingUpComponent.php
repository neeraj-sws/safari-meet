<?php

namespace App\Livewire\Front\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('components.layouts.guest_login')]
class TravelPartnerSingUpComponent extends Component
{

    public $password;
    public $password_confirmation;
    public $remember = false;
    public $agencyName, $licenseNumber, $contactPerson, $phoneNumber, $website, $location, $yearsOfExperience, $email;
    public $terms;

    public function register()
    {
        $this->validate([
            'agencyName' => 'required|string|max:255',
            'licenseNumber' => 'required|string|min:8|max:20',
            'contactPerson' => 'required|string|max:255',
            'phoneNumber' => 'required|string|min:10|max:15|regex:/^[0-9+()\s-]+$/',
            'email' => 'required|email|unique:users,email',
            'website' => 'required|url',
            'location' => 'required',
            'yearsOfExperience' => 'required|numeric|min:0',
            'password' => [
                'required',
                'confirmed',
                'min:6',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[\W_]/'
            ],
        ]);

        User::create([
            'name' => $this->agencyName,
            'email' => $this->email,
            'user_type' => 1,
            'license_number' => $this->licenseNumber,
            'contact_person' => $this->contactPerson,
            'phone_number' => $this->phoneNumber,
            'website_url' => $this->website,
            'location' => $this->location,
            'experience_year' => $this->yearsOfExperience,
            'password' => Hash::make($this->password),
        ]);

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Registration successful. You can now log in']);
        return redirect()->to('/login');
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

    public function getConfirmPasswordRulesProperty()
    {
        $password = $this->password_confirmation ?? '';

        return [
            'lower' => preg_match('/[a-z]/', $password),
            'upper' => preg_match('/[A-Z]/', $password),
            'number' => preg_match('/[0-9]/', $password),
            'special' => preg_match('/[\W_]/', $password),
            'length' => strlen($password) >= 6,
        ];
    }

    public function getConfirPasswordRulesProperty()
    {
        $password = $this->password_confirmation ?? '';

        return [
            'lower' => preg_match('/[a-z]/', $password),
            'upper' => preg_match('/[A-Z]/', $password),
            'number' => preg_match('/[0-9]/', $password),
            'special' => preg_match('/[\W_]/', $password),
            'length' => strlen($password) >= 6,
        ];
    }

    public function getCanSubmitProperty()
    {
        return collect($this->passwordRules)->every(fn($v) => $v) &&
            collect($this->confirmPasswordRules)->every(fn($v) => $v);
    }

    public function render()
    {
        return view('livewire.front.auth.travelPartnerSingUp-component');
    }
}
