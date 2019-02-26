<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Recipe;
use Illuminate\View\View;

class StatisticController extends Controller
{
    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $recipes = Recipe::whereUserId(user()->id)
            ->select('slug', _('title'))
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
