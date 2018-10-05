<?php

namespace App\Http\ViewComposers\Navbar;

use App\Models\Like;
use Illuminate\View\View;

class VisitorLikesComposer
{
    /**
     * Bind data to the view
     * @param  View  $view
     * @return void
     */
    public function compose(View $view): void
    {
        $view->with('visitor_likes', cache()->rememberForever('visitor_likes', function () {
            return Like::whereVisitorId(visitor_id())->count();
        }));
    }
}
