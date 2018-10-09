<?php

namespace App\Http\ViewComposers\Footer;

use App\Models\Like;
use App\Models\User;
use Illuminate\View\View;

class TopRecipersComposer
{
    /**
     * Bind data to the view
     * @param  View  $view
     * @return void
     */
    public function compose(View $view): void
    {
        // $top_recipers = cache()->remember('top_recipers', config('cache.timing.top_recipers'), function () {
        //     return User::orderBy('popularity', 'desc')
        //         ->limit(10)
        //         ->get(['id', 'name', 'popularity']);
        // });
        $likes = Like::whereDay('created_at', date('j'))->get();

        $users = $likes->map(function ($like) {
            return $like->recipe->user->name;
        })->toArray();
        $result = array_count_values($users);
        $result = array_sort($result);
        $result = array_reverse($result);
        $top_recipers = array_slice($result, 0, 10);

        $view->with(compact('top_recipers'));
    }
}
