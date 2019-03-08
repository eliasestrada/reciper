<?php

namespace App\Http\ViewComposers\Navbar;

use App\Models\Help;
use Illuminate\View\View;

class TrashComposer
{
    /**
     * Bind data to the view
     *
     * @param \Illuminate\View\View $view
     * @return void
     */
    public function compose(View $view): void
    {
        if (user() && user()->hasRole('master')) {
            $view->with('trash_notif', cache()->rememberForever('trash_notif', function () {
                return Help::onlyTrashed()->exists();
            }));
        } else {
            $view->with('trash_notif', false);
        }
    }
}
