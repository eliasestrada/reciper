<?php

namespace App\Http\ViewComposers\UserMenu;

use App\Models\Feedback;
use Illuminate\View\View;

class FeedbackComposer
{
    /**
     * Bind data to the view
     * @param  View  $view
     * @return void
     */
    public function compose(View $view) : void
    {
		if (user()) {
			$view->with('all_feedback', getDataNotifMarkup(
				Feedback::where('created_at', '>', user()->contact_check)->count())
			);
		}
    }
}