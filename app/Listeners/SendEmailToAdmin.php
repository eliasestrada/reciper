<?php

namespace App\Listeners;

use Carbon\Carbon;
use App\Mail\UserRegisteredMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailToAdmin
{
    // Create the event listener
    public function __construct()
    {
        //
    }

    public function handle(Registered $event)
    {
		\Mail::to('deliciousfood.kh@gmail.com')->send(new UserRegisteredMail);
		// $job = (new SendEmailJob)->delay(
		// 	Carbon::now()->addSeconds(10)
		// );
		// dispatch($job);
    }
}
