<?php

namespace App\Providers;

use App\Models\Title;
use App\Models\Recipe;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class FooterServiceProvider extends ServiceProvider
{

    public function boot()
    {
		// Sharing random recipes for footer
		if (Schema::hasTable('recipes') || Schema::hasTable('titles')) {
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
		} else {
			\Log::emergency(trans('logs.no_recipes_or_titles_table'));
		}
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
