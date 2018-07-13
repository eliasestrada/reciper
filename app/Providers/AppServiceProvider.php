<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Title;
use App\Models\Category;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap services
     * @return void
     */
    public function boot() : void
    {
		\Schema::defaultStringLength(191);

		$this->showListOfCategories();
		$this->updateLastUserVisit();
    }

	/**
     * @return void
     */
	public function updateLastUserVisit() : void
	{
		view()->composer('includes.footer', function ($view) {
			if (auth()->check()) {
				User::whereId(user()->id)->update(['last_visit_at' => NOW()]);
			}
		});
	}

	/**
     * @return void
     */
	public function showListOfCategories() : void
	{
		$category_names = Category::get(['name_' . locale()])->toArray();
		view()->share(compact('category_names'));
	}
}
