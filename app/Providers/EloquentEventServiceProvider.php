<?php

namespace App\Providers;

use App\Models\Recipe;
use Illuminate\Support\ServiceProvider;

class EloquentEventServiceProvider extends ServiceProvider
{
    public function boot()
    {
		$this->listOfAllObservers();
	}


	public function listOfAllObservers()
	{
		Recipe::observe(\App\Observers\RecipeObserver::class);
	}
}
