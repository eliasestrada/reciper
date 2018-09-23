<?php

namespace App\Http\Controllers;

use App\Models\Recipe;

class StatisticsController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recipes = Recipe::whereUserId(user()->id)
            ->select('id', 'title_' . lang())
            ->withCount('likes')
            ->withCount('views')
            ->get();

        $most_viewed = $recipes->where('views_count', $recipes->max('views_count'))->first();
        $most_liked = $recipes->where('likes_count', $recipes->max('likes_count'))->first();

        return view('statistics.index', compact(
            'recipes', 'most_viewed', 'most_liked'
        ));
    }
}
