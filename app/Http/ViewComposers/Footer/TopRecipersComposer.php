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
        $top_recipers = cache()->remember('top_recipers', config('cache.timing.top_recipers'), function () {
            return Like::whereDay('created_at', date('j'))->get();
        });

        $users = $top_recipers->map(function ($like) {
            return $like->recipe->user->id . '<split>' . $like->recipe->user->name;
        })->toArray();

        $users = array_slice(array_reverse(array_sort(array_count_values($users))), 0, 10);

        $top_recipers = [];

        foreach ($users as $name => $value) {
            $explode = explode('<split>', $name);
            array_push($top_recipers, [
                'id' => $explode[0],
                'name' => $explode[1],
            ]);
        }

        $view->with(compact('top_recipers'));
    }
}
