<?php

namespace App\Http\ViewComposers\Footer;

use App\Models\Recipe;
use Illuminate\View\View;
use Illuminate\Database\QueryException;

class RandomRecipesComposer
{
    /**
     * Bind data to the view
     * 
     * @throws \Illuminate\Database\QueryException
     * @param \Illuminate\View\View $view
     * @return void
     */
    public function compose(View $view): void
    {
        $cache_time = config('cache.timing.random_recipes');

        try {
            $random_recipes = cache()->remember('random_recipes', $cache_time, function () {
                return Recipe::select('slug', _('title') . ' as title')
                    ->inRandomOrder()
                    ->done(1)
                    ->limit(10)
                    ->get()
                    ->toArray();
            });
            $view->with(compact('random_recipes'));
        } catch (QueryException $e) {
            $view->with('random_recipes', []);
            report_error($e);
        }
    }
}
