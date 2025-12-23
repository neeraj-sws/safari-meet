<?php

namespace App\Livewire\Admin\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.guest_login')]
class LoginComponent extends Component
{
    public $email;
    public $password;
    public $remember = false;

    protected $rules = [
        'email' => 'required|email|exists:admins,email',
        'password' => 'required|min:6',
    ];


    public function login()
    {
        $this->validate();

        $remember = $this->remember ? true : false;

        if (Auth::guard('admin')->attempt(['email' => $this->email, 'password' => $this->password], $remember)) {
            $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Login successful!']);
            return redirect()->route('admin.dashboard');
        } else {
            $this->dispatch('swal:toast', ['type' => 'error', 'title' => '', 'message' => 'Invalid credentials.']);
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function render()
    {

        return view('livewire.admin.auth.login-component');
    }
}
