<?php

namespace App\Http\ViewComposers\UserMenu;

use Illuminate\View\View;

class LogsComposer
{
    /**
     * Bind data to the view
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
		if (user()) {
			$files = count(\File::files(storage_path('logs')));
			$all_logs = getDataNotifMarkup($files);
			$view->with(compact('all_logs'));
		}
    }
}