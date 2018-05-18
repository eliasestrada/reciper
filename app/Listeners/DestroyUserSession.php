<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DestroyUserSession
{
    /**
     * Create the event listener
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event
     */
    public function handle(Registered $event)
    {
		if (auth()->check()) {
			auth()->logout();
		}
    }
}
