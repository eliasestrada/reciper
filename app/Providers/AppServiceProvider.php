<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\User;
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
        //\Artisan::call('migrate');

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
                User::whereId(user()->id)->update(['updated_at' => now()]);
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
