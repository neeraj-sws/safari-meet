<?php

namespace App\Livewire\Front\Auth;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.guest')]
class ChangePassword extends Component
{
    public $old_password, $password, $password_confirmation;

    public function render()
    {
        return view('livewire.front.auth.change-password');
    }

    public function save()
    {
        $this->validate([
            'old_password' => 'required',
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
            ],
        ]);

        if (!Hash::check($this->old_password, Auth::user()->password)) {
            $this->dispatch('swal:toast', ['type' => 'error', 'message' => 'The old password is incorrect.']);
            return;
        }

        $user = Auth::user();
        $user->password = Hash::make($this->password);
        $user->save();

        $this->dispatch('swal:toast', ['type' => 'success', 'message' => 'Password updated successfully!']);
        $this->reset(['old_password', 'password', 'password_confirmation']);

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
}
