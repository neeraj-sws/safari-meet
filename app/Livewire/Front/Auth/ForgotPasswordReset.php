<?php

namespace App\Livewire\Front\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.guest_login')]
class ForgotPasswordReset extends Component
{
    public $email;
    public $password;
    public $password_confirmation;
    public $showPassword = false;
    public $showConfirmPassword = false;

    public function mount($slug)
    {

        $this->email = base64_decode($slug);
    }

    public function render()
    {
        return view('livewire.front.auth.forgot-password-reset');
    }


    protected function rules()
    {
        return [
            'password' => [
                'required',
                'string',
                'confirmed',
                'min:6',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[\W_]/',
            ],
        ];
    }

    protected function messages()
    {
        return [
            'password.confirmed' => 'Passwords do not match.',
            'password.min'       => 'Password must be at least :min characters.',
            'password.regex'     => 'Password must include lower, upper, number, special characters.',
        ];
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

    public function resetPassword()
    {
        $this->validate();


        $user = User::where('email', $this->email)->first();

        if (!$user) {

            $this->dispatch('swal:toast', [
                'type' => 'error',
                'title' => 'Error',
                'message' => 'Invalid reset link or user not found.',
            ]);
            return;
        }

        $user->password = Hash::make($this->password);
        $user->save();

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => 'Success',
            'message' => 'Password changed successfully. You may now login.',
        ]);
        return redirect()->route('login');
    }
}
