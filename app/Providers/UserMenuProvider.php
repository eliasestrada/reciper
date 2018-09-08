<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class UserMenuProvider extends ServiceProvider
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
    }

    /**
     * @return void
     */
    public function countAndComposeAllNotifications(): void
    {
        view()->composer('includes.nav.navbar',
            'App\Http\ViewComposers\UserMenu\NotificationsComposer');
    }

    /**
     * @return void
     */
    public function countAndComposeAllFeedback(): void
    {
        view()->composer('includes.nav.navbar',
            'App\Http\ViewComposers\UserMenu\FeedbackComposer');
    }

    /**
     * @return void
     */
    public function countAndComposeAllUnapprovedRecipes(): void
    {
        view()->composer('includes.nav.navbar',
            'App\Http\ViewComposers\UserMenu\UnapprovedRecipesComposer');
    }

    /**
     * @return void
     */
    public function countAndComposeAllLogFiles(): void
    {
        view()->composer('includes.nav.navbar',
            'App\Http\ViewComposers\UserMenu\LogsComposer');
    }
}
