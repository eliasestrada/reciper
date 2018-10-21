<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Popularity;
use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Recipe;
use App\Models\Visitor;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * @param integer $id of the recipe
     * @return integer
     */
    public function check($id)
    {
        if (request()->cookie('ekilx') == $id) {
            return 1;
        }
        return Visitor::whereIp(request()->ip())->first()->likes()->whereRecipeId($id)->count();
    }

    /**
     * @param integer $id of the recipe
     * @return object
     */
    public function like(Request $request, $id): ?object
    {
        $visitor = Visitor::whereIp(request()->ip())->first();

        if (request()->cookie('ekilx') != $id) {
            $recipe = Recipe::find($id);
            cache()->forget('visitor_likes');

            $visitor->likes()->create(['recipe_id' => $recipe->id]);
            Popularity::add(config('custom.popularity_for_like'), $recipe->user_id);

            return response()->json(['liked' => 1])
                ->withCookie('ekilx', \Crypt::encrypt($id), 5555);
        }
        return response()->json(['liked' => 0])->withCookie('ekilx', $id, -5);
    }

    /**
     * @param integer $id of the recipe
     * @return object
     */
    public function dislike($id): ?object
    {
        $recipe = Recipe::find($id);
        $visitor = Visitor::whereIp(request()->ip())->first();
        cache()->forget('visitor_likes');

        $visitor->likes()->whereRecipeId($recipe->id)->delete();
        Popularity::remove(config('custom.popularity_for_like'), $recipe->user_id);

        return response()->json(['liked' => 0])->withCookie('ekilx', $id, -1);
    }
}
