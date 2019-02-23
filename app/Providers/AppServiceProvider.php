<?php

namespace App\Providers;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Laravel\Horizon\Horizon;
use Illuminate\Support\ServiceProvider;
use App\Repos\CategoryRepo;

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
            return (new CategoryRepo)->getAllInArray();
        });

        view()->share('categories', array_map(function ($cat) {
            return ['id' => $cat['id'], 'name' => $cat[_('name')]];
        }, $categories));
    }

    /**
     * @return void
     */
    public function horizonRightsChecker(): void
    {
        /** @var \Closure $onlyMaster */
        $onlyMaster = function ($request) {
            if ($request->user() && $request->user()->hasRole('master') || $this->app->isLocal()) {
                return true;
            }
            throw new UnauthorizedHttpException('Unauthorized');
        };
        Horizon::auth($onlyMaster);
    }
}
