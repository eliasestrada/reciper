<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Database\QueryException;
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
        // \Artisan::call('wipe');
        $this->showListOfCategories();
        $this->horizonRightsChecker();
    }

    /**
     * @return void
     */
    public function showListOfCategories(): void
    {
        view()->share('categories', cache()->rememberForever('categories', function () {
            try {
                return Category::select('id', 'name_' . LANG() . ' as name')->get()->toArray();
            } catch (QueryException $e) {
                no_connection_error($e, __CLASS__);
            }
            return [];
        }));
    }

    /**
     * @return void
     */
    public function horizonRightsChecker(): void
    {
        Horizon::auth(function ($request) {
            if ($request->user() && $request->user()->hasRole('master')) {
                return true;
            }
            throw new UnauthorizedHttpException('Unauthorized');
        });
    }
}
