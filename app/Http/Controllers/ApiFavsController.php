<?php

namespace App\Http\Controllers;

use App\Models\Fav;
use App\Models\Recipe;
use Illuminate\Http\Request;

class ApiFavsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($recipe_id)
    {
        if (!$recipe_id || !is_numeric($recipe_id) || Recipe::whereId($recipe_id)->doesntExist()) {
            return response('fail');
        }

        if (Fav::where([['user_id', user()->id], ['recipe_id', $recipe_id]])->exists()) {
            Fav::where([['user_id', user()->id], ['recipe_id', $recipe_id]])->delete();
            return response('');
        }

        Fav::create(['user_id' => user()->id, 'recipe_id' => $recipe_id]);
        return response('active');
    }
}
