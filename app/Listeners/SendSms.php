<?php

namespace App\Listeners;

use App\Events\RecipeIsReady;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendSms
{
    /** Handle the event */
    public function handle(RecipeIsReady $event)
    {
        $client = new \Nexmo\Client(
			new \Nexmo\Client\Credentials\Basic(
				config('services.nexmo.key'),
				config('services.nexmo.secret')
			)
		);
	
		$client->message()->send([
			'type' => 'unicode',
			'from' => config('services.nexmo.sms_from'),
			'to' => config('services.nexmo.sms_to'),
			'text' => trans('recipes.new_recipe')
		]);
    }
}
