<?php

namespace App\Http\ViewComposers\Footer;

use App\Models\User;
use Illuminate\View\View;

class TopRecipersComposer
{
    /**
     * Bind data to the view
     * @param  View  $view
     * @return void
     */
    public function compose(View $view): void
    {
        $top_recipers = cache()->remember('top_recipers', config('cache.timing.top_recipers'), function () {
            return User::orderBy('xp', 'desc')
                ->limit(10)
                ->get(['id', 'name', 'xp']);
        });

        $view->with(compact('top_recipers'));
    }
}
