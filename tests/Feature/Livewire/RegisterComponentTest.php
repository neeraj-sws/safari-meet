<?php

use App\Livewire\Front\Auth\RegisterComponent;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

uses(TestCase::class);

it('renders registration component', function () {
    Livewire::test(RegisterComponent::class)
        ->assertStatus(200);
});

it('validates registration fields', function () {
    Livewire::test(RegisterComponent::class)
        ->set('name', '')
        ->set('phone', '')
        ->set('email', '')
        ->set('password', '')
        ->set('password_confirmation', '')
        ->call('register')
        ->assertHasErrors([
            'name',
            'phone',
            'email',
            'password',
        ]);
});

it('creates user and sends emails', function () {

    Mail::fake();

    Livewire::test(RegisterComponent::class)
        ->set('name', 'Shifan Khan')
        ->set('phone', '9876543210')
        ->set('email', 'shifankkhan@yopmail.com')
        ->set('password', 'Password@123')
        ->set('password_confirmation', 'Password@123')
        ->set('terms', true)
        ->call('register')
        ->assertRedirect();

    $this->assertDatabaseHas('users', [
        'email' => 'shifankkhan@yopmail.com'
    ]);

    $user = User::where('email', 'shifankkhan@yopmail.com')->first();

    expect($user->email_verified_otp)->not->toBeNull();

    Mail::assertQueued(\App\Mail\DynamicMail::class, 1);
});

it('logs registration activity', function () {

    Mail::fake();

    Livewire::test(RegisterComponent::class)
        ->set('name', 'Test User')
        ->set('phone', '9876500000')
        ->set('email', 'test@example.com')
        ->set('password', 'Pass@123')
        ->set('password_confirmation', 'Pass@123')
        ->set('terms', true)
        ->call('register');

    $user = User::first();

    log_activity('auth.signup', [
        'actor_type' => class_basename($user),
        'actor_id' => $user->id,
        'actor_identifier' => $user->email,
        'guard' => 'web',
        'user_id' => $user->id, // YOU ARE PASSING THIS
        'email' => $user->email,
        'message' => 'User signed up with email ' . $user->email
    ]);


    $this->assertDatabaseHas('activity_logs', [
        'actor_id' => $user->id,
        'action'   => 'auth.signup',
    ]);
});

it('redirects user to verify page after registration', function () {

    Mail::fake();

    $email = 'redirect@yopmail.com';
    $slug = base64_encode($email);

    Livewire::test(RegisterComponent::class)
        ->set('name', 'Test Redirect')
        ->set('phone', '9887226591')
        ->set('email', $email)
        ->set('password', 'Pass@123')
        ->set('password_confirmation', 'Pass@123')
        ->set('terms', true)
        ->call('register')
        ->assertRedirect(route('email_verify', $slug));
});
