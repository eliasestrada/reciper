<?php

namespace App\Providers;

use App\Models\Recipe;
use Illuminate\Support\ServiceProvider;

class EloquentEventServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap services
     * @return void
	 * @TODO:
     */
    public function boot() : void
    {
		$this->listOfAllObservers();
	}

	/**
     * @return void
     */
	public function listOfAllObservers() : void
	{
		//Recipe::observe(\App\Observers\RecipeObserver::class);
	}
}
