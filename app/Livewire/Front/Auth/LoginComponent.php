<?php

namespace App\Livewire\Front\Auth;

use App\Helpers\UserHelper;
use App\Mail\DynamicMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Laravel\Socialite\Facades\Socialite;

#[Layout('components.layouts.guest_login')]
class LoginComponent extends Component
{
    public $email;
    public $password;
    public $remember = false, $showMessage = false, $previousUrl, $showPassword = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    public function mount($type = null)
    {
        if ($type == 'success') {
            $this->showMessage = true;
        }
        $this->previousUrl = url()->previous();
    }



    public function login()
    {
        $this->validate();

        if (Auth::guard('web')->attempt(
            ['email' => $this->email, 'password' => $this->password],
            $this->remember
        )) {

            $user = User::where('email', $this->email)->first();

            if (!$user) {
                $this->dispatch('swal:toast', [
                    'type' => 'error',
                    'title' => '',
                    'message' => 'User not found.'
                ]);
                return;
            }
            if ($user->status === 2) {
                Auth::guard('web')->logout();
                request()->session()->invalidate();
                request()->session()->regenerateToken();

                $this->dispatch('swal:toast', [
                    'type' => 'info',
                    'title' => '',
                    'message' => 'Something went wrong. Please contact the support team.'
                ]);
                $this->reset('email', 'password');
                return;
            }

            if (empty($user->email_verified_at)) {
                Auth::guard('web')->logout();
                $this->dispatch('swal:toast', [
                    'type' => 'error',
                    'title' => '',
                    'message' => 'Please verify your email.'
                ]);
                $slug = base64_encode($user->email);

                $data = [
                    'username' =>   empty($user->contact_person) ? $user->name : $user->contact_person,
                    'otp' => $user->email_verified_otp,
                    'year' => date('Y'),
                ];

                do {
                    $otp = rand(100000, 999999);
                } while (User::where('email_verified_otp', $otp)->exists());

                $user->email_verified_otp = $otp;
                $user->otp_expires_at = Carbon::now()->addMinutes(10);
                $user->save();

                $parsed = UserHelper::parseTemplate('AGENTEMAILVERIFY', $data);
                Mail::to($this->email)->queue(
                    new DynamicMail($parsed['subject'], $parsed['body'])
                );

                return $this->redirect(route('email_verify', $slug), navigate: true);
            }

            $IdAddress = UserHelper::UserIPDetails();

            $user->update([
                'ip_address' => $IdAddress['ip_address'],
                'browser' => $IdAddress['browser'],
                'os' => $IdAddress['os'],
                'device' => $IdAddress['is_mobile'] ? 'Mobile' : 'Desktop',
                'login_at' => now(),
                'username' => empty($user->name) ? UserHelper::generateUsername($user->name) : $user->username,
            ]);

            $this->dispatch('swal:toast', [
                'type' => 'success',
                'title' => '',
                'message' => 'Login successful!'
            ]);

            if ($user->is_profile_complete == 0) {

                return redirect()->route('profile-edit')->with('info', 'Please complete your profile.');
            }
            return redirect()->to($this->previousUrl);
            // return $this->redirect(route('home'), navigate: true);
        } else {
            $this->dispatch('swal:toast', [
                'type' => 'error',
                'title' => '',
                'message' => 'Invalid credentials.'
            ]);
        }
    }


    public function logout()
    {
        $user = Auth::guard('web')->user();
        $user->update([
            'logout_at' => date('Y-m-d H:i:s'),
        ]);
        Auth::guard('web')->logout();
        return redirect()->route('login');
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

    public function render()
    {
        return view('livewire.front.auth.login-component')->layoutData([
            'seoContents' => '',
        ]);
    }
}
