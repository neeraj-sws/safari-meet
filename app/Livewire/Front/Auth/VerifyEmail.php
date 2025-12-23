<?php

namespace App\Livewire\Front\Auth;

use App\Helpers\UserHelper;
use App\Mail\DynamicMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;

#[Layout('components.layouts.guest_login')]
class VerifyEmail extends Component
{
    public $otp = ['', '', '', '', '', ''];
    public $email = '';
    public $showEmailInput = false;
    public $message, $user;

    public function mount($slug)
    {

        $this->user = User::where('email', base64_decode($slug))->first();
        if (empty($this->user)) {
            return redirect()->route('agent_registration');
        }
        $this->email = $this->user->email;
    }

    public function verifyOtp()
    {
        $this->reset('message');

        $otpCode = implode('', $this->otp);

        if (strlen($otpCode) !== 6 || !ctype_digit($otpCode)) {
            $this->addError('otp', 'Please enter a valid 6-digit OTP.');
            return;
        }

        $user = User::where('email', $this->email)
            ->where('email_verified_otp', $otpCode)
            ->first();

        if (!$user) {
            $this->addError('otp', 'Invalid OTP. Please try again.');
            return;
        }

        if (Carbon::parse($user->otp_expires_at)->lt(now())) {
            $this->addError('otp', 'OTP has expired. Please request a new one.');
            return;
        }


        $user->email_verified_at = now();
        $user->email_verified_otp = null;
        $user->otp_expires_at = null;


        $data = [
            'username' => ($user->user_type == 1) ? $user->contact_person : $user->name,
            'year' => date('Y'),
        ];

        $parsed = UserHelper::parseTemplate('AFTERREGISTRATION', $data);
        Mail::to($this->email)->queue(
            new DynamicMail($parsed['subject'], $parsed['body'])
        );
        if ($user->user_type == 0) {
            $user->status = 0;
            $data = [
                'user_name' => ($user->user_type == 1) ? $user->contact_person : $user->name,
                'status' => 'Approved',
                'remark' => "Thank you for registering with us! We're happy to inform you that your account has been successfully approved.<br><br>
                You can now log in and start using all of our features.<br><br>
                If you have any questions or need assistance, feel free to reach out to our support team.",
                'year' => date('Y'),
            ];

            $parsed = UserHelper::parseTemplate('REGISTRATIONSTATUS', $data);
            Mail::to($user->email)->queue(
                new DynamicMail($parsed['subject'], $parsed['body'])
            );
            
            log_activity('user.approve', [
                'user_id' => $user->id,
                'email' => $user->email ?? null,
                'message' => 'User approved for email ' . $user->email ?? null
            ]);
        } else {

            log_activity('agent.approve', [
                'actor_type' => class_basename($user),
                'actor_id' => $user->id,
                'actor_identifier' => $user->email,
                'guard' => 'web',
                'user_id' => $user->id,
                'email' => $user->email ?? null,
                'message' => 'Agent approved for email ' . $user->email ?? null
            ]);
        }
        $user->save();
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Email verified successfully!']);
        if ($user->user_type == 1) {
            return redirect()->route('thankyou');
        } else {
            return redirect()->route('login')->with('success', 'Email verified successfully!');
        }
    }

    public function requestNewOtp()
    {
        $this->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $otp = rand(100000, 999999);
        $user = User::where('email', $this->email)->first();
        $user->email_verified_otp = $otp;
        $user->otp_expires_at = now()->addMinutes(10);
        $user->save();
        $data = [
            'username' => $user->contact_person,
            'otp' => $user->email_verified_otp,
            'year' => date('Y'),
        ];
        $parsed = UserHelper::parseTemplate('AGENTEMAILVERIFY', $data);
        Mail::to($this->email)->queue(
            new DynamicMail($parsed['subject'], $parsed['body'])
        );
        
        log_activity('otp.verificationrequest', [
            'actor_type' => class_basename($user),
            'actor_id' => $user->id,
            'actor_identifier' => $user->email,
            'guard' => 'web',
            'user_id' => $user->id,
            'email' => $user->email ?? null,
            'message' => 'Agent requested OTP verification for email ' . $user->email ?? null
        ]);

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'A new OTP has been sent to your email.']);
    }

    public function render()
    {
        return view('livewire.front.auth.verify-email');
    }
}
