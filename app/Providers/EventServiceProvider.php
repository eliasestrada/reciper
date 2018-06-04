<?php

namespace App\Providers;

use Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     */
    protected $listen = [
        'Illuminate\Auth\Events\Registered' => [
            'App\Listeners\LogNewUser',
            'App\Listeners\SendEmailToAdmin',
		],
		'Illuminate\Auth\Events\Login' => [
            'App\Listeners\LogLoggedInUser',
        ],
		'Illuminate\Auth\Events\Attempting' => [
            'App\Listeners\LogAttemptingUser',
        ],
		'App\Events\RecipeIsReady' => [
            'App\Listeners\SendSms',
        ],
    ];
}
