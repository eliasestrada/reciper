<?php

namespace App\Providers;

use App\Models\User;
use App\Repos\CategoryRepo;
use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\Horizon;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        \Schema::defaultStringLength(191);
        $this->showListOfCategories();
        $this->horizonRightsChecker();

        if ($this->app->env === 'production') {
            url()->forceScheme('https');
        }
    }

    /**
     * @return void
     */
    public function showListOfCategories(): void
    {
        $categories = cache()->rememberForever('categories', function () {
            return CategoryRepo::getAllInArray();
        });

        view()->share('categories', array_map(function ($category) {
            return [
                'id' => $category['id'],
                'name' => $category[_('name')],
            ];
        }, $categories));
    }

    /**
     * @return void
     */
    public function horizonRightsChecker(): void
    {
        Horizon::auth(function ($request) {
            if ($request->user() && $request->user()->hasRole('master') || $this->app->isLocal()) {
                return true;
            }
            throw new UnauthorizedHttpException('Unauthorized');
        });
    }
}
