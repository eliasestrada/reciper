<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;

class DebugProvider extends ServiceProvider
{
    /**
     * If set to true, you will be able to see all sql queries
     * @var boolean
     */
    protected $show_sql = false;
    protected $show_bindings = false;

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
    public function databaseSettings(): void
    {
        if (app()->env != 'production') {
            \DB::listen(function ($query) {
                if ($this->show_sql) {
                    dump($query->sql);
                }

                if ($this->show_bindings) {
                    dump($query->bindings);
                }

            });
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }

    }
}
