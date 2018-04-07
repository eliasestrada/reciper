<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Recipe;
use App\Title;
use DB;

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

		$title_footer = Title::select('text')->where('name', 'Подвал')->first();

		View::share([
			'footer_rand_recipes' => $footer_rand_recipes,
			'title_footer' => $title_footer
		]);

		// Turn on ability to see queries
		// DB::listen( function ( $query ) {
		// 	dump($query->sql);
		//  dump($query->bindings);
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
