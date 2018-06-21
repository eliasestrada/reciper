<?php

namespace App\Providers;

use Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap services
     * @return void
     */
    public function boot() : void
    {
        Broadcast::routes();

        require base_path('routes/channels.php');
    }
}
