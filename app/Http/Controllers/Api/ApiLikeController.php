<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Recipe;
use App\Models\Visitor;
use Illuminate\Http\Request;

class ApiLikeController extends Controller
{
    /**
     * @param integer $id of the recipe
     * @return integer
     */
    public function check($id)
    {
        if (request()->cookie('ekilx') != $id) {
            $visitor = Visitor::whereIp(request()->ip())->first();
            $likes = $visitor->likes()->where('recipe_id', $id)->count();

            return $likes;
        }
        return 1;
    }

    /**
     * @param integer $id of the recipe
     * @return object
     */
    public function like(Request $request, $id): ?object
    {
        $visitor = Visitor::whereIp(request()->ip())->first();

        if (request()->cookie('ekilx') != $id) {
            Like::create(['visitor_id' => $visitor->id, 'recipe_id' => $id]);
            event(new \App\Events\RecipeGotLiked(Recipe::find($id)));

            return response()->json(['liked' => 1])->withCookie('ekilx', \Crypt::encrypt($id), 5555);
        }
        return response()->json(['liked' => 0])->withCookie('ekilx', $id, -5);
    }

    /**
     * @param integer $id of the recipe
     * @return object
     */
    public function dislike($id): ?object
    {
        $visitor = Visitor::whereIp(request()->ip())->first();
        Like::where(['visitor_id' => $visitor->id, 'recipe_id' => $id])->delete();

        event(new \App\Events\RecipeGotDisliked(Recipe::find($id)));

        return response()->json(['liked' => 0])->withCookie('ekilx', $id, -1);
    }
}
