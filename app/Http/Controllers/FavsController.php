<?php

namespace App\Http\Controllers;

use App\Models\Fav;
use Illuminate\Http\Request;

class FavsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['recipe_id' => 'required|numeric']);

        if (Fav::where([['user_id', user()->id], ['recipe_id', $request->recipe_id]])->exists()) {
            Fav::where([['user_id', user()->id], ['recipe_id', $request->recipe_id]])->delete();
            return redirect("/recipes/$request->recipe_id")->withSuccess(trans('recipes.deleted_from_favs'));
        }

        Fav::create(['user_id' => user()->id, 'recipe_id' => $request->recipe_id]);
        return redirect("/recipes/$request->recipe_id")->withSuccess(trans('recipes.added_to_favs'));
    }
}
