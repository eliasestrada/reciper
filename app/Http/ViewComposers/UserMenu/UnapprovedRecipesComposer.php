<?php

namespace App\Http\ViewComposers\UserMenu;

use App\Models\Recipe;
use Illuminate\View\View;

class UnapprovedRecipesComposer
{
    /**
     * Bind data to the view
     * @param  View  $view
     * @return void
     */
    public function compose(View $view): void
    {
        if (user() && user()->hasRole('admin')) {
            $view->with('all_unapproved', cache()->rememberForever('all_unapproved', function () {
                return Recipe::query()->approved(0)->ready(1)->count();
            }));
        }
    }
}
