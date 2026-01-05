<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogLogout
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
    public function handle(Logout $event): void
    {
        $user = $event->user;
        // use action names you like
        log_activity('auth.logout', [
            'user_id' => $user->id,
            'email' => $user->email ?? null,
            'guard' => $event->guard ?? null,
        ]);
    }
}
