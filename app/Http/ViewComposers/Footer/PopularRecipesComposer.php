<?php

namespace App\Http\ViewComposers\Footer;

use App\Models\Recipe;
use Illuminate\View\View;

class PopularRecipesComposer
{
    /**
     * Bind data to the view
     * @param  View  $view
     * @return void
     */
    public function compose(View $view): void
    {
        $popular_recipes = cache()->remember('popular_recipes', config('cache.timing.popular_recipes'), function () {
            return Recipe::select('id', 'title_' . lang() . ' as title')
                ->withCount('likes')
                ->orderBy('likes_count', 'desc')
                ->done(1)
                ->limit(10)
                ->get()
                ->toArray();
        });

        $view->with(compact('popular_recipes'));
    }
}
