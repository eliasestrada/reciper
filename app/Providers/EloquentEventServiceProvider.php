<?php

namespace App\Providers;

use App\Models\Recipe;
use Illuminate\Support\ServiceProvider;

class EloquentEventServiceProvider extends ServiceProvider
{
    // Bootstrap services.
    public function boot()
    {
        Recipe::observe(\App\Observers\RecipeObserver::class);
    }
}
