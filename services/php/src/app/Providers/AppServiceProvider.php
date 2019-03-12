<?php

namespace App\Providers;

use App\Repos\CategoryRepo;
use Laravel\Horizon\Horizon;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        \Schema::defaultStringLength(191);

        $this->horizonRightsChecker();
        $this->enableSqlQueryLogging(false);
        $this->app->env === 'production' ? url()->forceScheme('https') : null;

        view()->share('categories', (new CategoryRepo)->getCache());
        dark_theme() ? Horizon::night() : null;
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


    /**
     * Method for debuging sql queries
     *
     * @codeCoverageIgnore
     * @param bool $enable
     * @return void
     */
    private function enableSqlQueryLogging(bool $enable): void
    {
        if (app()->env == 'local' && $enable) {
            \DB::listen(function ($query) {
                dump("{$query->sql} | {$query->time} s");
                // dump($query->bindings);
            });
        }
    }
}
