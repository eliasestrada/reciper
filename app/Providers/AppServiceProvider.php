<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Title;
use App\Models\Recipe;
use App\Models\Category;
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

		$all_categories = Recipe::distinct()->select('category_id')->get();

		view()->share(compact('all_categories'));

		// DB::listen( function ( $query ) {
		// 	dump($query->sql);
		// 	dump($query->bindings);
		// });

		// Update last visit
		view()->composer('*', function ($view) {
			if (auth()->check()) {
				User::whereId(user()->id)->update([
					'updated_at' => NOW()
				]);
			}
		});
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
