<?php

namespace App\Http\ViewComposers\Footer;

use Schema;
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

		if (Schema::hasTable('titles')) {
			$view->with(compact('title_footer'));
		} else {
			logger()->emergency("Table titles wasn't found while trying to get titles for footer, name of the method: getAndComposeTitleForFooter");
		}
    }
}