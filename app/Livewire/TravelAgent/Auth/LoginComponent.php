<?php

namespace App\Livewire\TravelAgent\Auth;

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
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];


    public function login()
    {
        $this->validate();
        if (Auth::guard('agent')->attempt(['email' => $this->email, 'password' => $this->password])) {
            if (Auth::guard('agent')->user()->status == 1) {
                $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Login successful!']);
                return redirect()->route('agent.dashboard');
            }
            Auth::guard('agent')->logout();
            $this->dispatch('swal:toast', ['type' => 'info', 'title' => '', 'message' => 'Please contact to our Team']);
        } else {
            $this->dispatch('swal:toast', ['type' => 'error', 'title' => '', 'message' => 'Invalid credentials.']);
        }
    }

    public function logout()
    {
        Auth::guard('agent')->logout();
        return redirect()->route('agent.login');
    }

    public function render()
    {

        return view('livewire.travel-agent.auth.login-component');
    }
}
