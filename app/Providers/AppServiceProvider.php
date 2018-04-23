<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Recipe;
use App\Models\Title;

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

		$all_categories = Recipe::distinct()
				->orderBy('category')
				->get([ 'category' ])
				->toArray();

		// Sharing random recipes for footer
		$footer_rand_recipes = Recipe::inRandomOrder()
				->whereApproved(1)
				->limit(8)
				->get([ 'id', 'title' ]);

		$title_footer = Title::whereName('Подвал')->first([ 'text' ]);

		view()->share(compact(
			'all_categories',
			'footer_rand_recipes',
			'title_footer'
		));

		/**
		 * Turn on ability to see queries
		 * If you want to use it, add "use DB;" to the top of the page
		 */
		// DB::listen( function ( $query ) {
		// 	dump($query->sql);
		// 	dump($query->bindings);
		// });
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
