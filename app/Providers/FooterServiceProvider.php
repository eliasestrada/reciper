<?php

namespace App\Providers;

use App\Models\Title;
use App\Models\Recipe;
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
		view()->composer('includes.footer', function ($view) {
			$view->with('rand_recipes',
				Recipe::inRandomOrder()
					->whereApproved(1)
					->limit(20)
					->get([ 'id', 'title' ]));
		});
	}

    public function getAndComposePopularRecipes()
    {
		view()->composer('includes.footer', function ($view) {
			$view->with('popular_recipes',
				Recipe::whereApproved(1)
					->orderBy('likes', 'desc')
					->limit(10)
					->get([ 'id', 'title' ]));
		});
	}


	public function getAndComposeTitleForFooter()
	{
		view()->composer('includes.footer', function ($view) {
			$view->with('title_footer', Title::whereName('Подвал')->first(['text']));
		});
	}
}
