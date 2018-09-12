<?php

namespace App\Http\ViewComposers\Footer;

use App\Models\Title;
use Illuminate\View\View;

class TitleFooterComposer
{
    /**
     * Bind data to the view
     * @param  View  $view
     * @return void
     */
    public function compose(View $view): void
    {
        if (user() && user()->hasRole('admin')) {
            $title_footer = cache()->rememberForever('title_footer', function () {
                return Title::whereName('footer')->value('text_' . lang());
            });

            $view->with(compact('title_footer'));
        }
    }
}
