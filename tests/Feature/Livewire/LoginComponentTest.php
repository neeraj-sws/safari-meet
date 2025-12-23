<?php

use App\Livewire\Front\Auth\LoginComponent;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    Mail::fake();
});

it('logs in successfully when credentials are correct and email is verified', function () {

    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('Password@123'),
        'email_verified_at' => now(),
        'is_profile_complete' => 1,
    ]);

    Livewire::test(LoginComponent::class)
        ->set('email', 'test@example.com')
        ->set('password', 'Password@123')
        ->call('login')
        ->assertRedirect(); // Should redirect to previous URL
});

it('fails login with invalid credentials', function () {

    Livewire::test(LoginComponent::class)
        ->set('email', 'wrong@yopmail.com')
        ->set('password', 'wrongpass')
        ->call('login');
});

it('fails when user status is blocked (status = 2)', function () {



    Livewire::test(LoginComponent::class)
        ->set('email', 'shifan@yopmail.com')
        ->set('password', 'Demo@123')
        ->call('login');
});

it('redirects user to email verification when email is not verified', function () {

    $user = User::factory()->create([
        'email' => 'verify@example.com',
        'password' => Hash::make('Password@123'),
        'email_verified_at' => null,
        'email_verified_otp' => 123456,
    ]);

    $slug = base64_encode('verify@example.com');

    Livewire::test(LoginComponent::class)
        ->set('email', 'verify@example.com')
        ->set('password', 'Password@123')
        ->call('login')
        ->assertRedirect(route('email_verify', $slug));
});

it('redirects to profile-edit when profile is incomplete', function () {

    $user = User::factory()->create([
        'email' => 'profile@example.com',
        'password' => Hash::make('Password@123'),
        'email_verified_at' => now(),
        // 'is_profile_complete' => 0,
        
    ]);

    Livewire::test(LoginComponent::class)
        ->set('email', 'profile@example.com')
        ->set('password', 'Password@123')
        ->call('login')
        ->assertRedirect(route('profile-edit'));
});
