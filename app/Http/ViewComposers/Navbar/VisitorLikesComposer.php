<?php

namespace App\Http\ViewComposers\Navbar;

use App\Models\Like;
use Illuminate\Database\QueryException;
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
        try {
            $view->with('visitor_likes', cache()->rememberForever('visitor_likes', function () {
                return Like::whereVisitorId(visitor_id())->count();
            }));
        } catch (QueryException $e) {
            $view->with('visitor_likes', null);
            no_connection_error($e, __CLASS__);
        }
    }
}
