<?php

namespace App\Http\ViewComposers\Footer;

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
        $view->with('top_recipers', cache()->get('top_recipers', []));
    }
}
