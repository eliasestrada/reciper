<?php

namespace App\Providers;

use App\Models\Recipe;
use Illuminate\Support\ServiceProvider;

class EloquentEventServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Recipe::observe(\App\Observers\RecipeObserver::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
