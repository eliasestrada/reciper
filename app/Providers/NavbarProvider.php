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
        $this->countAndComposeAllNotifications();
        $this->countAndComposeAllFeedback();
        $this->countAndComposeAllUnapprovedRecipes();
        $this->countAndComposeAllLogFiles();
        $this->countAndComposeAllVisitorLikes();
    }

    /**
     * @return void
     */
    public function countAndComposeAllNotifications(): void
    {
        view()->composer('includes.nav.navbar',
            \App\Http\ViewComposers\Navbar\NotificationsComposer::class);
    }

    /**
     * @return void
     */
    public function countAndComposeAllFeedback(): void
    {
        view()->composer('includes.nav.navbar',
            \App\Http\ViewComposers\Navbar\FeedbackComposer::class);
    }

    /**
     * @return void
     */
    public function countAndComposeAllUnapprovedRecipes(): void
    {
        view()->composer('includes.nav.navbar',
            \App\Http\ViewComposers\Navbar\UnapprovedRecipesComposer::class);
    }

    /**
     * @return void
     */
    public function countAndComposeAllLogFiles(): void
    {
        view()->composer('includes.nav.navbar',
            \App\Http\ViewComposers\Navbar\LogsComposer::class);
    }

    /**
     * @return void
     */
    public function countAndComposeAllVisitorLikes(): void
    {
        view()->composer('includes.nav.navbar',
            \App\Http\ViewComposers\Navbar\VisitorLikesComposer::class);
    }
}
