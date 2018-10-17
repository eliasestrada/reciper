<?php

namespace App\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;

class BladeProvider extends ServiceProvider
{
    /**
     * Bootstrap services
     * @return void
     */
    public function boot(): void
    {
        $this->statements();
    }

    /**
     * @return void
     */
    public function statements(): void
    {
        Blade::if('hasRole', function ($role) {
            return auth()->check() && user()->hasRole($role);
        });
        Blade::if('isActive', function () {
            return auth()->check() && user()->isActive();
        });
        Blade::component('comps.list-of-recipes', 'listOfRecipes');
        Blade::component('comps.magic-form', 'magicForm');
    }
}
