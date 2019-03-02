<?php

namespace App\Http\ViewComposers\Footer;

use App\Models\Recipe;
use Illuminate\View\View;
use Illuminate\Database\QueryException;

class PopularRecipesComposer
{
    /**
     * Bind data to the view
     * 
     * @param \Illuminate\View\View $view
     * @return void
     */
    public function compose(View $view): void
    {
        $cache_time = config('cache.timing.popular_recipes');

        try {
            $popular_recipes = cache()->remember('popular_recipes', $cache_time, function () {
                return Recipe::select('slug', _('title') . ' as title')
                    ->withCount('likes')
                    ->orderBy('likes_count', 'desc')
                    ->done(1)
                    ->limit(10)
                    ->get()
                    ->toArray();
            });
            $view->with(compact('popular_recipes'));
        } catch (QueryException $e) {
            $view->with('popular_recipes', []);
            no_connection_error($e, __CLASS__);
        }
    }
}
