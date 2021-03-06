<?php

namespace App\Http\ViewComposers\Navbar;

use App\Models\Recipe;
use Illuminate\View\View;

class UnapprovedRecipesComposer
{
    /**
     * Bind data to the view
     * 
     * @param \Illuminate\View\View $view
     * @return void
     */
    public function compose(View $view): void
    {
        if (user() && user()->hasRole('admin')) {
            $view->with('unapproved_notif', cache()->rememberForever('unapproved_notif', function () {
                return Recipe::where(_('approver_id', true), 0)->approved(0)->ready(1)->exists();
            }));
        } else {
            $view->with('unapproved_notif', false);
        }
    }
}
