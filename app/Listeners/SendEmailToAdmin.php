<?php

namespace App\Listeners;

use Carbon\Carbon;
use App\Jobs\SendEmailJob;
use App\Mail\UserRegisteredMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailToAdmin implements ShouldQueue
{
    // Create the event listener
    public function __construct()
    {
        //
    }

    public function handle(Registered $event)
    {
		$job = (new SendEmailJob)->delay(
			Carbon::now()->addSeconds(10)
		);

		dispatch($job);
    }
}
