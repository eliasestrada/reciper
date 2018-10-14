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
            ->withCount('favs')
            ->get();

        $most_viewed = $recipes->where('views_count', $recipes->max('views_count'))->first();
        $most_liked = $recipes->where('likes_count', $recipes->max('likes_count'))->first();
        $most_favs = $recipes->where('favs_count', $recipes->max('favs_count'))->first();

        return view('statistics.index', compact(
            'recipes', 'most_viewed', 'most_liked', 'most_favs'
        ));
    }

    /**
     * Chart.js
     */
    public function likesViewsChart()
    {
        $views = $this->getDataFromUser('views');
        $likes = $this->getDataFromUser('likes');
        $favs = $this->getDataFromUser('favs');

        return [
            'labels' => $views->pluck('month'),
            'options' => [],
            'datasets' => [
                [
                    'label' => trans('users.views2'),
                    'fill' => false,
                    'backgroundColor' => '#484074',
                    'borderColor' => '#484074',
                    'data' => $views->pluck('sum'),
                ],
                [
                    'label' => trans('users.likes'),
                    'fill' => false,
                    'backgroundColor' => '#cf4545',
                    'borderColor' => '#cf4545',
                    'data' => $likes->pluck('sum'),
                ],
                [
                    'label' => trans('messages.favorites'),
                    'fill' => false,
                    'backgroundColor' => '#d49d10',
                    'borderColor' => '#d49d10',
                    'data' => $favs->pluck('sum'),
                ],
            ],
        ];
    }

    /**
     * @param string $column
     */
    public function getDataFromUser(string $column)
    {
        $recipes = user()->recipes()->where('created_at', '>=', now()->subYear())->get();

        $rules = array_map(function ($i) {
            return [
                'month' => now()->subMonths($i - 1)->month,
                'from' => now()->subMonths($i),
                'to' => now()->subMonths($i - 1),
                'sum' => 0,
            ];
        }, [12, 11, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1]);

        foreach ($rules as $key => $rule) {
            $rules[$key]['sum'] += $recipes->map(function ($recipe) use ($rule, $column) {
                return $recipe[$column]
                    ->where('created_at', '>=', $rule['from'])
                    ->where('created_at', '<=', $rule['to'])
                    ->count();
            })->sum();
        }

        // Convert month number to month name
        $rules_with_month_name = collect($rules)->map(function ($rule) {
            $rule['month'] = trans("date.month_{$rule['month']}");
            return $rule;
        });

        return collect($rules_with_month_name);
    }
}
