<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FooterProvider extends ServiceProvider
{
    /**
     * Bootstrap services
     * @return void
     */
    public function boot(): void
    {
        $this->getAndComposeRandomRecipes();
        $this->getAndComposePopularRecipes();
        $this->getAndComposeTitleForFooter();
        $this->getAndComposeTopRecipersForFooter();
    }

    /**
     * @return void
     */
    public function getAndComposeRandomRecipes(): void
    {
        view()->composer('includes.footer',
            'App\Http\ViewComposers\Footer\RandomRecipesComposer');
    }

    /**
     * @return void
     */
    public function getAndComposePopularRecipes(): void
    {
        view()->composer('includes.footer',
            'App\Http\ViewComposers\Footer\PopularRecipesComposer');
    }

    /**
     * @return void
     */
    public function getAndComposeTitleForFooter(): void
    {
        view()->composer('includes.footer',
            'App\Http\ViewComposers\Footer\TitleFooterComposer');
    }

    /**
     * @return void
     */
    public function getAndComposeTopRecipersForFooter(): void
    {
        view()->composer('includes.footer',
            'App\Http\ViewComposers\Footer\TopRecipersComposer');
    }
}
