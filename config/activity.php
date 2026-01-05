<?php

return [

    'retention_days' => env('ACTIVITY_RETENTION_DAYS', 90),

    'whitelist_actions' => [
        'auth.login',
        'auth.logout',
        'safari.delete',
        'safari.join',
        'wishlist.add',
        'wishlist.remove',
        'enquiry.create',
        'auth.signup',
        'otp.verificationrequest',
        'agent.approve',
        'user.approve',
        'auth.forgot_password',
        'profile.verification',
        'update.profile',
        'safari.create',
        'seat.allotted',
        'seat.updated',
    ],

    'messages' => [
        'auth.login'         => 'logged in successfully.',
        'auth.logout'        => 'logged out.',
        'safari.delete'      => 'deleted a safari.',
        'safari.join'        => 'joined a safari.',
        'wishlist.add'       => 'added an item to wishlist.',
        'wishlist.remove'    => 'removed an item from wishlist.',
        'shared_safari.join' => 'joined a shared safari.',
        'enquiry.create'     => 'submitted a new enquiry.',
        'auth.signup'        => 'signed up.',
    ],

    'log_full_request' => env('ACTIVITY_LOG_FULL_REQUEST', true),

    'store_parameters' => env('ACTIVITY_STORE_PARAMETERS', true),
];
