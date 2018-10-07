<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services
     * @return void
     */
    public function boot(): void
    {
        \Schema::defaultStringLength(191);
        // \Artisan::call('migrate');

        $this->showListOfCategories();
        $this->updateLastUserVisit();
    }

    /**
     * @return void
     */
    public function updateLastUserVisit(): void
    {
        view()->composer('includes.footer', function ($view) {
            if (auth()->check()) {
                event(new \App\Events\UserIsOnline);
            }
        });
    }

    /**
     * @return void
     */
    public function showListOfCategories(): void
    {
        $categories = cache()->rememberForever('categories', function () {
            return Category::get(['id', 'name_' . lang()]);
        });
        view()->share(compact('categories'));
    }
}
