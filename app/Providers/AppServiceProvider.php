<?php

namespace App\Providers;

use DB;
use Schema;
use App\Models\User;
use App\Models\Title;
use App\Models\Category;
use Laravel\Dusk\DuskServiceProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * If set to true, you will be able to see all sql queries
	 * @var boolean
	 */
	protected $show_queries = false;

	/**
	 * Bootstrap services
     * @return void
     */
    public function boot() : void
    {
		$this->databaseSettings();
		$this->showListOfCategories();
		$this->updateLastUserVisit();
    }

	/**
     * @return void
     */
	public function databaseSettings() : void
	{
		Schema::defaultStringLength(191);

		if ($this->show_queries && app()->env != 'production') {
			DB::listen(function ($query) {
				dump($query->sql);
				dump($query->bindings);
			});
		}
	}

	/**
     * @return void
     */
	public function updateLastUserVisit() : void
	{
		if (Schema::hasTable('users')) {
			view()->composer('includes.footer', function ($view) {
				if (auth()->check()) {
					User::whereId(user()->id)->update([
						'last_visit_at' => NOW()
					]);
				}
			}); 
		} else {
			logger()->emergency("Table users wasn't found while trying to update last user visit, name of the method: updateLastUserVisit");
		}
	}

	/**
     * @return void
     */
	public function showListOfCategories() : void
	{
		if (Schema::hasTable('categories')) {
			$category_names = Category::get(['name_' . locale()])->toArray();
			view()->share(compact('category_names'));
		} else {
			logger()->emergency("Table categories wasn't found while trying to show list of categories, name of the method: showListOfCategories");
		}
	}

	public function register()
	{
		if ($this->app->environment('local', 'testing')) {
			$this->app->register(DuskServiceProvider::class);
		}
	}
}
