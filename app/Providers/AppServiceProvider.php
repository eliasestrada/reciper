<?php

namespace App\Providers;

use App\Models\Title;
use App\Models\Recipe;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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

		view()->share(compact('all_categories'));

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
