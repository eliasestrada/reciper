<?php

namespace App\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap services
     * @return void
     */
    public function boot() : void
    {
		$this->listOfAllBlade();
	}

	/**
     * @return void
     */
	public function listOfAllBlade() : void
	{
		Blade::if('admin', function() {
			return auth()->check() && user()->isAdmin();
		});
	}
}
