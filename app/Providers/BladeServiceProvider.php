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

		Blade::component('comps.forms.title-field', 'titleField');
		Blade::component('comps.forms.time-field', 'timeField');
		Blade::component('comps.forms.meal-field', 'mealField');
		Blade::component('comps.forms.ingredients-field', 'ingredientsField');
		Blade::component('comps.forms.intro-field', 'introField');
		Blade::component('comps.forms.text-field', 'textField');
		Blade::component('comps.forms.image-field', 'imageField');

		Blade::component('comps.list-of-recipes', 'listOfRecipes');
		Blade::component('comps.edit_form', 'editForm');
	}
}
