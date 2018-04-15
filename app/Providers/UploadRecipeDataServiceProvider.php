<?php

namespace App\Providers;

use App\Helpers\SaveRecipeData;
use Illuminate\Support\ServiceProvider;

class UploadRecipeDataServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Helpers\Contracts\SaveRecipeDataContract', function() {
			return new SaveRecipeData();
		});
    }
}
