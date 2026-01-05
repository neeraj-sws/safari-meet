<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $user = $event->user;
        // use action names you like
        log_activity('auth.login', [
            'user_id' => $user->id,
            'email' => $user->email ?? null,
            'guard' => $event->guard ?? null,
        ]);
    }
}
