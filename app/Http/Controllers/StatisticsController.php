<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\User;

class StatisticsController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recipes = Recipe::whereUserId(user()->id)
            ->select('id', 'title_' . LANG())
            ->withCount('likes')
            ->withCount('views')
            ->withCount('favs')
            ->get();

        $most_viewed = $recipes->where('views_count', $recipes->max('views_count'))->first();
        $most_liked = $recipes->where('likes_count', $recipes->max('likes_count'))->first();
        $most_favs = $recipes->where('favs_count', $recipes->max('favs_count'))->first();

        return view('statistics.index', compact(
            'recipes', 'most_viewed', 'most_liked', 'most_favs'
        ));
    }
}
