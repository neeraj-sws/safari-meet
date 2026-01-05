<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SocialController extends Controller
{
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $role = session('social_role', 'user');
        $user_type = $role == 'user' ? 0 : 1;
        $existing = User::where('email', $googleUser->getEmail())->first();

        if ($existing && $existing->user_type !== $user_type) {
            return redirect()->route('login')->with('error', 'This email is already registered as a different role.');
        }

        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'user_type' => $role == 'user' ? 0 : 1
            ]
        );

        Auth::login($user, true);

        return redirect()->route('home');
    }

    public function handleFacebookCallback()
    {
        $facebookUser = Socialite::driver('facebook')->stateless()->user();

        $role = session('social_role', 'user');
        $user_type = $role == 'user' ? 0 : 1;
        $existing = User::where('email', $facebookUser->getEmail())->first();

        if ($existing && $existing->user_type != $user_type) {
            return redirect()->route('login')->with('error', 'This email is already registered as a different role.');
        }

        $user = User::firstOrCreate(
            ['email' => $facebookUser->getEmail()],
            [
                'name' => $facebookUser->getName(),
                'user_type' => $role == 'user' ? 0 : 1
            ]
        );

        Auth::login($user, true);

        return redirect()->route('home');
    }
}
