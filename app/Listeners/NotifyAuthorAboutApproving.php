<?php

namespace App\Listeners;

use App\Events\RecipeGotApproved;
use App\Models\User;
use App\Notifications\RecipeApprovedNotification;
use App\Notifications\UserGotXpPoints;

class NotifyAuthorAboutApproving
{
    /**
     * Send notification and mark recipe as approved if it wasn't approved before
     *
     * @param  RecipeGotApproved  $event
     * @return void
     */
    public function handle(RecipeGotApproved $event)
    {
        if (!$event->recipe->isPublished()) {
            $author = User::whereId($event->recipe->user_id)->first();
            $author->notify(new RecipeApprovedNotification($event->recipe));

            if ($author->xp < 9990) {
                $author->notify(new UserGotXpPoints(config('custom.xp_for_approve')));
            }

            $event->recipe->update([
                _('published') => 1,
            ]);
        }
    }
}
