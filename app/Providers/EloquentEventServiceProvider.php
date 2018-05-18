<?php

namespace App\Providers;

use App\Models\Recipe;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class EloquentEventServiceProvider extends ServiceProvider
{
    // Bootstrap services.
    public function boot()
    {
		if (Schema::hasTable('recipes')) {
			Recipe::observe(\App\Observers\RecipeObserver::class);
		} else {
			\Log::emergency(trans('logs.no_recipes_table'));
		}
    }
}
