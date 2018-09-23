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
            ->withCount('likes')
            ->withCount('views')
            ->get();

        $views = $recipes->where('views_count', $recipes->max('views_count'))->first();
        $likes = $recipes->where('likes_count', $recipes->max('likes_count'))->first();

        $most_viewed = $views ? $views->getTitle() : '-';
        $most_liked = $likes ? $likes->getTitle() : '-';

        return view('statistics.index', compact(
            'recipes', 'most_viewed', 'most_liked'
        ));
    }
}
