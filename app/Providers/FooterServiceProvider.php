<?php

namespace App\Providers;

use App\Models\Title;
use App\Models\Recipe;
use Illuminate\Support\ServiceProvider;

class FooterServiceProvider extends ServiceProvider
{

    public function boot()
    {
		// Sharing random recipes for footer
		$footer_rand_recipes = Recipe::inRandomOrder()
				->whereApproved(1)
				->limit(8)
				->get([ 'id', 'title' ]);

		$title_footer = Title::whereName('Подвал')->first([ 'text' ]);

		view()->composer('includes.footer', function ($view) use ($footer_rand_recipes, $title_footer) {
			$view->with(compact(
				'footer_rand_recipes',
				'title_footer'
			));
		});
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
