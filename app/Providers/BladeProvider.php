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
        $this->other();
        $this->componentsForForms();
        $this->statementsForUserPermission();
    }

    /**
     * @return void
     */
    public function statementsForUserPermission(): void
    {
        Blade::if('hasRole', function ($role) {
            return auth()->check() && user()->hasRole($role);
        });
    }

    /**
     * @return void
     */
    public function componentsForForms(): void
    {
        Blade::component('comps.forms.title-field', 'titleField');
        Blade::component('comps.forms.time-field', 'timeField');
        Blade::component('comps.forms.meal-field', 'mealField');
        Blade::component('comps.forms.ingredients-field', 'ingredientsField');
        Blade::component('comps.forms.intro-field', 'introField');
        Blade::component('comps.forms.text-field', 'textField');
        Blade::component('comps.forms.image-field', 'imageField');
    }

    /**
     * @return void
     */
    public function other(): void
    {
        Blade::component('comps.list-of-recipes', 'listOfRecipes');
        Blade::component('comps.magic-form', 'magicForm');
    }
}
