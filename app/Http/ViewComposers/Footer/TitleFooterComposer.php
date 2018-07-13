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
    public function compose(View $view) : void
    {
		$title_footer = Title::whereName('footer')->value('text_' . locale());
		$view->with(compact('title_footer'));
    }
}