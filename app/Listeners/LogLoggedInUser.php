<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogLoggedInUser
{
    // Create the event listener
    public function __construct()
    {
        //
    }

    public function handle(Login $event)
    {
        \Log::info(trans('logs.user_just_logged_in'), [
			'user' => $event->user,
			'remember' => $event->remember
		]);
    }
}
