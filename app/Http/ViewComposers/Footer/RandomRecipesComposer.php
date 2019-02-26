<?php

namespace App\Http\ViewComposers\Footer;

use App\Models\Recipe;
use Illuminate\View\View;
use Illuminate\Database\QueryException;

class RandomRecipesComposer
{
    /**
     * Bind data to the view
     * @param  View  $view
     * @return void
     */
    public function compose(View $view): void
    {
        try {
            $random_recipes = cache()->remember('random_recipes', config('cache.timing.random_recipes'), function () {
                return Recipe::select('slug', _('title') . ' as title')
                    ->inRandomOrder()
                    ->done(1)
                    ->limit(10)
                    ->get()
                    ->toArray();
            });
            $view->with(compact('random_recipes'));
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            $view->with('random_recipes', []);
        }
    }
}
