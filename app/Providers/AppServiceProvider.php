<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Recipe;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		Schema::defaultStringLength(191);

		// Sharing random recipes for footer
		$footer_rand_recipes = Recipe::inRandomOrder()
				->select(['id', 'title'])
				->where('approved', 1)
				->limit(8)
				->get();
		View::share('footer_rand_recipes', $footer_rand_recipes);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
