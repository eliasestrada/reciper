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
    public function store($recipe_id)
    {
        // $request->validate(['recipe_id' => 'required|numeric']);

        if (Fav::where([['user_id', user()->id], ['recipe_id', $recipe_id]])->exists()) {
            Fav::where([['user_id', user()->id], ['recipe_id', $recipe_id]])->delete();
            return response('');
        }

        Fav::create(['user_id' => user()->id, 'recipe_id' => $recipe_id]);
        return response('active');
    }
}
