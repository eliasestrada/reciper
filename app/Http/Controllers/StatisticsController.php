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
            ->select('slug', 'title_' . LANG())
            ->withCount('likes')
            ->withCount('views')
            ->withCount('favs')
            ->get();

        return view('statistics.index', [
            'recipes' => $recipes,
            'next_streak' => now()->subDay()->diffInHours(user()->streak_check),
            'most_favs' => $recipes->where('favs_count', $recipes->max('favs_count'))->first(),
            'most_liked' => $recipes->where('likes_count', $recipes->max('likes_count'))->first(),
            'most_viewed' => $recipes->where('views_count', $recipes->max('views_count'))->first(),
        ]);
    }
}
