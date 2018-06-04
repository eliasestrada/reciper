<?php

namespace App\Providers;

use DB;
use Schema;
use App\Models\User;
use App\Models\Title;
use App\Models\Recipe;
use App\Models\Category;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
		$this->databaseSettings();
		$this->showListOfCategories();
		$this->updateLastUserVisit();
    }


	public function databaseSettings()
	{
		Schema::defaultStringLength(191);
		// Script that shows current executed query
		// DB::listen( function ( $query ) {
		// 	dump($query->sql);
		// 	dump($query->bindings);
		// });
	}


	public function updateLastUserVisit()
	{
		view()->composer('*', function ($view) {
			if (auth()->check()) {
				User::whereId(user()->id)->update([
					'updated_at' => NOW()
				]);
			}
		});
	}


	public function showListOfCategories()
	{
			$all_categories = Recipe::distinct()->select('category_id')->get();
			view()->share(compact('all_categories'));
	}
}
