<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class NavbarProvider extends ServiceProvider
{
    /**
     * Bootstrap services
     * @return void
     */
    public function boot(): void
    {
        $this->countAndCompose();
    }

    /**
     * @return void
     */
    public function countAndCompose(): void
    {
        view()->composer('includes.nav.navbar',
            \App\Http\ViewComposers\Navbar\NotificationsComposer::class);

        view()->composer('includes.nav.navbar',
            \App\Http\ViewComposers\Navbar\FeedbackComposer::class);

        view()->composer('includes.nav.navbar',
            \App\Http\ViewComposers\Navbar\UnapprovedRecipesComposer::class);

        view()->composer('includes.nav.navbar',
            \App\Http\ViewComposers\Navbar\LogsComposer::class);
    }
}
