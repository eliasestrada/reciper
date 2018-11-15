<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class NavbarProvider extends ServiceProvider
{
    /**
     * All navbar composer namespaces
     *
     * @var array $composers
     */
    private $composers = [
        \App\Http\ViewComposers\Navbar\NotificationsComposer::class,
        \App\Http\ViewComposers\Navbar\FeedbackComposer::class,
        \App\Http\ViewComposers\Navbar\UnapprovedRecipesComposer::class,
        \App\Http\ViewComposers\Navbar\LogsComposer::class,
        \App\Http\ViewComposers\Navbar\TrashComposer::class,
    ];

    /**
     * Bootstrap services
     *
     * @return void
     */
    public function boot(): void
    {
        array_walk($this->composers, function ($composer) {
            view()->composer('includes.nav.navbar', $composer);
        });
    }
}
