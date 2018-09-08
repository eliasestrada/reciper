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
    public function compose(View $view): void
    {
        if (user()->isMaster()) {
            $view->with('all_logs', count(\File::files(storage_path('logs'))));
        }
    }
}
