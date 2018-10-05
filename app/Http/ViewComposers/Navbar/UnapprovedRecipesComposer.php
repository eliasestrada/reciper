<?php

namespace App\Http\ViewComposers\Navbar;

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
            $view->with('unapproved_notif', cache()->rememberForever('unapproved_notif', function () {
                return Recipe::query()->where(lang() . '_approver_id', 0)->approved(0)->ready(1)->exists();
            }));
        } else {
            $view->with('unapproved_notif', false);
        }
    }
}
