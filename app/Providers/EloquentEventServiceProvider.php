<?php

namespace App\Providers;

use App\Models\Recipe;
use Illuminate\Support\ServiceProvider;

class EloquentEventServiceProvider extends ServiceProvider
{
    public function boot()
    {
		Recipe::observe(\App\Observers\RecipeObserver::class);
    }
}
