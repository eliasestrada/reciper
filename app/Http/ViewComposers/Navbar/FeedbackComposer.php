<?php

namespace App\Http\ViewComposers\Navbar;

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
        if (user() && user()->hasRole('admin')) {
            if (user()->contact_check == null) {
                user()->update(['contact_check' => now()]);
            }
            $feedback_notif = cache()->rememberForever('feedback_notif', function () {
                return Feedback::where('created_at', '>', user()->contact_check)->exists();
            });
            $view->with(compact('feedback_notif'));
        } else {
            $view->with('feedback_notif', false);
        }
    }
}
