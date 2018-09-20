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
        $this->composerRandomRecipes();
        $this->composerPopularRecipes();
        $this->composerTitle();
        $this->composerDocuments();
        $this->composerTopRecipers();
    }

    /**
     * @return void
     */
    public function composerRandomRecipes(): void
    {
        view()->composer('includes.footer',
            'App\Http\ViewComposers\Footer\RandomRecipesComposer');
    }

    /**
     * @return void
     */
    public function composerPopularRecipes(): void
    {
        view()->composer('includes.footer',
            'App\Http\ViewComposers\Footer\PopularRecipesComposer');
    }

    /**
     * @return void
     */
    public function composerTitle(): void
    {
        view()->composer('includes.footer',
            'App\Http\ViewComposers\Footer\TitleFooterComposer');
    }

    /**
     * @return void
     */
    public function composerTopRecipers(): void
    {
        view()->composer('includes.footer',
            'App\Http\ViewComposers\Footer\TopRecipersComposer');
    }

    /**
     * @return void
     */
    public function composerDocuments(): void
    {
        view()->composer('includes.footer',
            'App\Http\ViewComposers\Footer\DocumentsComposer');
    }
}
