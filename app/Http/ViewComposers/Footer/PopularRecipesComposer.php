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
            return Recipe::select('id', 'title_' . lang())
                ->withCount('likes')
                ->orderBy('likes_count', 'desc')
                ->done(1)
                ->limit(10)
                ->get();
        });

        $view->with(compact('popular_recipes'));
    }
}
