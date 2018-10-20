<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\Horizon;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services
     * @return void
     */
    public function boot(): void
    {
        \Schema::defaultStringLength(191);
        // \Artisan::call('wipe');
        $this->showListOfCategories();
        // $this->horizon();
    }

    /**
     * @return void
     */
    public function showListOfCategories(): void
    {
        view()->share('categories', cache()->rememberForever('categories', function () {
            return Category::select('id', 'name_' . lang() . ' as name')->get()->toArray();
        }));
    }

    public function horizon()
    {
        Horizon::auth(function ($request) {
            if ($request->user() && $request->user()->hasRole('master')) {
                return true;
            }
            throw new UnauthorizedHttpException('Unauthorized');
        });
    }
}
