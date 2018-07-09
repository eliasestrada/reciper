<?php

namespace App\Http\ViewComposers\UserMenu;

use Schema;
use App\Models\Feedback;
use Illuminate\View\View;

class FeedbackComposer
{
    /**
     * Bind data to the view
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
		if (Schema::hasTable('feedback')) {
			if (user()) {
				$view->with('all_feedback', getDataNotifMarkup(
					Feedback::where('created_at', '>', user()->contact_check)->count())
				);
			}
		} else {
			logger()->emergency("Table feedback wasn't found while trying to count all unproved recipes, name of the method: countAndComposeAllFeedback");
		}
    }
}