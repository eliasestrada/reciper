<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Attempting;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogAttemptingUser
{
    // Create the event listener
    public function __construct()
    {
        //
    }

    public function handle(Attempting $event)
    {
        \Log::info(trans('logs.user_attempting_to_log_in'), [
			'user' => $event->remember,
			'credentials' => $event->credentials,
		]);
    }
}
