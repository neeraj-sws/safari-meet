<?php

use App\Livewire\Front\Auth\AgentRegistration;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

uses(TestCase::class);

it('renders agent registration component', function () {
    Livewire::test(AgentRegistration::class)
        ->assertStatus(200);
});

it('validates agent registration fields', function () {
    Livewire::test(AgentRegistration::class)
        ->set('agency_name', '')
        ->set('contact_person', '')
        ->set('phone', '')
        ->set('email', '')
        ->set('password', '')
        ->set('password_confirmation', '')
        ->set('country', '')
        ->set('state', '')
        ->set('city', '')
        ->set('experience', '')
        ->call('register')
        ->assertHasErrors([
            'agency_name',
            'contact_person',
            'phone',
            'email',
            'country',
            'state',
            'city',
            'experience',
            'password',
            'terms',
        ]);
});

it('creates agent user and sends email', function () {

    Mail::fake();

    Livewire::test(AgentRegistration::class)
        ->set('agency_name', 'Safari Tours')
        ->set('contact_person', 'Shifan Khan')
        ->set('phone', '9876543210')
        ->set('email', 'agenttest@gmail.com') // must be a DNS-valid domain!
        ->set('website', 'https://example.com')
        ->set('country', 1)
        ->set('state', 1)
        ->set('city', 1)
        ->set('experience', 5)
        ->set('password', 'Password@123')
        ->set('password_confirmation', 'Password@123')
        ->set('terms', true)
        ->call('register')
        ->assertRedirect(); // redirect must happen

    $this->assertDatabaseHas('users', [
        'email' => 'agenttest@gmail.com',
        'user_type' => 1
    ]);

    $user = User::where('email', 'agenttest@gmail.com')->first();

    expect($user->email_verified_otp)->not()->toBeNull();

    Mail::assertQueued(\App\Mail\DynamicMail::class, 1);
});

it('logs agent registration activity', function () {

    Mail::fake();

    Livewire::test(AgentRegistration::class)
        ->set('agency_name', 'Travel India')
        ->set('contact_person', 'Aman')
        ->set('phone', '9876505060')
        ->set('email', 'logtest@gmail.com')
        ->set('website', 'https://agency.com')
        ->set('country', 1)
        ->set('state', 1)
        ->set('city', 1)
        ->set('experience', 7)
        ->set('password', 'Password@123')
        ->set('password_confirmation', 'Password@123')
        ->set('terms', true)
        ->call('register');

    $user = User::where('email', 'logtest@gmail.com')->first();

    $this->assertDatabaseHas('activity_logs', [
        'actor_id' => $user->id,
        'guard' => 'web',
        'action' => 'auth.signup',
    ]);
});


it('redirects agent to email verify page', function () {

    Mail::fake();

    $email = 'redirectagent@gmail.com';
    $slug = base64_encode($email);

    Livewire::test(AgentRegistration::class)
        ->set('agency_name', 'Test Agency')
        ->set('contact_person', 'Aman Singh')
        ->set('phone', '9876511111')
        ->set('email', $email)
        ->set('website', 'https://example.com')
        ->set('country', 1)
        ->set('state', 1)
        ->set('city', 1)
        ->set('experience', 3)
        ->set('password', 'Password@123')
        ->set('password_confirmation', 'Password@123')
        ->set('terms', true)
        ->call('register')
        ->assertRedirect(route('email_verify', $slug));
});
