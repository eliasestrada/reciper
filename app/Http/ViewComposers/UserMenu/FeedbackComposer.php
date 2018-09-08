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
    public function compose(View $view): void
    {
        if (user() && user()->isAdmin()) {
            $all_feedback = cache()->rememberForever('all_feedback', function () {
                return Feedback::where('created_at', '>', user()->contact_check)->count();
            });

            $view->with(compact('all_feedback'));
        }
    }
}
