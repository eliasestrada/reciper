<?php

namespace App\Providers;

use Laravel\Dusk\DuskServiceProvider;
use Illuminate\Support\ServiceProvider;

class DebugProvider extends ServiceProvider
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
    public function boot()
    {
        $this->databaseSettings();
    }

    /**
     * @return void
     */
	public function databaseSettings() : void
	{
		if ($this->show_queries && app()->env != 'production') {
			DB::listen(function ($query) {
				dump($query->sql);
				dump($query->bindings);
			});
		}
	}

	/**
     * Register services.
     *
     * @return void
     */
	public function register() : void
	{
		if ($this->app->environment('local', 'testing')) {
			$this->app->register(DuskServiceProvider::class);
		}
	}
}
