<?php

namespace App\Providers;

use Laravel\Dusk\DuskServiceProvider;
use Illuminate\Support\ServiceProvider;

class DebugProvider extends ServiceProvider
{
    /**
     * If set to true, you will be able to see all sql queries
     * 
     * @var bool
     */
    protected $show_sql = false;

    /**
     * @var bool
     */
    protected $show_bindings = false;

    /**
     * Bootstrap services
     * 
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
        if ($this->app->environment('local')) {
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
