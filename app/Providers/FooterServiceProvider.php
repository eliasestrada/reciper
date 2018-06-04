<?php

namespace App\Providers;

use Schema;
use App\Models\Recipe;
use App\Models\Title;
use Illuminate\Support\ServiceProvider;

class FooterServiceProvider extends ServiceProvider
{

    public function boot()
    {
		$this->getAndComposeRandomRecipes();
		$this->getAndComposePopularRecipes();
		$this->getAndComposeTitleForFooter();
    }


    public function getAndComposeRandomRecipes()
    {
        if (Schema::hasTable('recipes')) {
			view()->composer('includes.footer', function ($view) {
				$view->with('rand_recipes',
					Recipe::inRandomOrder()
						->whereApproved(1)
						->limit(20)
						->get([ 'id', 'title' ]));
			});
		} else {
			logger()->emergency(trans('logs.no_table', ['table' => 'recipes']));
		}
	}

    public function getAndComposePopularRecipes()
    {
        if (Schema::hasTable('recipes')) {
			view()->composer('includes.footer', function ($view) {
				$view->with('popular_recipes',
					Recipe::whereApproved(1)
						->orderBy('likes', 'desc')
						->limit(10)
						->get([ 'id', 'title' ]));
			});
		} else {
			logger()->emergency(trans('logs.no_table', ['table' => 'recipes']));
		}
	}


	public function getAndComposeTitleForFooter()
	{
		if (Schema::hasTable('titles_ru')) {
			view()->composer('includes.footer', function ($view) {
				$view->with('title_footer', Title::whereName('Подвал')->first(['text']));
			});
		} else {
			logger()->emergency(trans('logs.no_table', ['table' => 'titles_ru']));
		}
	}
}
