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
						->where("approved_" . locale(), 1)
						->limit(20)
						->get([ 'id', "title_" . locale() ]));
			});
		} else {
			logger()->emergency("Table recipes wasn't found while trying to get list of random recipes, name of the method: getAndComposeRandomRecipes");
		}
	}

    public function getAndComposePopularRecipes()
    {
        if (Schema::hasTable('recipes')) {
			view()->composer('includes.footer', function ($view) {
				$view->with('popular_recipes',
					Recipe::select('id', 'title_' . locale())
						->withCount('likes')
						->orderBy('likes_count', 'desc')
						->where('ready_' . locale(), 1)
						->where('approved_' . locale(), 1)
						->limit(10)
						->get()
				);
			});
		} else {
			logger()->emergency("Table recipes wasn't found while trying to get popular recipes from database, name of the method: getAndComposePopularRecipes");
		}
	}


	public function getAndComposeTitleForFooter()
	{
		if (Schema::hasTable('titles')) {
			$title_footer = Title::whereName('footer')->value('text_' . locale());

			view()->composer('includes.footer', function ($view) use ($title_footer) {
				$view->with('title_footer', $title_footer);
			});
		} else {
			logger()->emergency("Table titles wasn't found while trying to get titles for footer, name of the method: getAndComposeTitleForFooter");
		}
	}
}
