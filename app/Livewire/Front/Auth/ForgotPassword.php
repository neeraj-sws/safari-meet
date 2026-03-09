<?php

namespace App\Livewire\Front\Auth;

use App\Helpers\UserHelper;
use App\Mail\DynamicMail;
use App\Models\User;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

#[Layout('components.layouts.guest_login')]
class ForgotPassword extends Component
{
    public $email;

    public function render()
    {
        return view('livewire.front.auth.forgot-password');
    }

    public function save()
    {

        $messages = [
            'email.required' => 'Please enter your email address.',
            'email.string'   => 'The email address must be a valid string.',
            'email.max'      => 'The email address may not be longer than 100 characters.',
            'email.email'    => 'Please enter a valid email address.',
        ];
        $this->validate([
            'email' => 'required|string|max:100|email:rfc,dns',
        ], $messages);;

        $user = User::where('email', $this->email)->first();

        if (!$user) {
            $this->dispatch('swal:toast', ['type' => 'error', 'title' => 'Error', 'message' => 'Email not found!']);
            return;
        }

        $data = [
            'first_name' => $user->name,
            'reset_link' => route('forgot_password_link', base64_encode($user->email)),
            'year' => date('Y'),
        ];

        $parsed = UserHelper::parseTemplate('FORGOTPASSWORD', $data);

        // Mail::to($user->email)->queue(
        //     new DynamicMail($parsed['subject'], $parsed['body'])
        // );

        dispatch(function () use ($user, $parsed) {
            Mail::to($user->email)->send(
                new DynamicMail($parsed['subject'], $parsed['body'])
            );
        })->afterResponse();
        
        log_activity('auth.forgot_password', [
            'user_id' => $user->id,
            'email' => $user->email ?? null,
            'message' => 'Password reset link sent to email ' . $user->email ?? null
        ]);

        $this->reset(['email']);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Password reset link sent!']);
    }
}
