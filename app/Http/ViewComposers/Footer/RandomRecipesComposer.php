<?php

namespace App\Http\ViewComposers\Footer;

use App\Models\Recipe;
use Illuminate\View\View;

class RandomRecipesComposer
{
    /**
     * Bind data to the view
     * @param  View  $view
     * @return void
     */
    public function compose(View $view): void
    {
        $random_recipes = cache()->remember('random_recipes', config('cache.timing.random_recipes'), function () {
            return Recipe::inRandomOrder()
                ->ready(1)
                ->approved(1)
                ->limit(20)
                ->get(['id', "title_" . lang()]);
        });

        $view->with(compact('random_recipes'));
    }
}
