<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Support\Collection;

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
        $views = $this->getDataFromUserScript('views');
        $likes = $this->getDataFromUserScript('likes');
        $favs = $this->getDataFromUserScript('favs');

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
     * @param User|null $user this param for testing purposes, coz I can just use auth()->user helper
     */
    public function getDataFromUserScript(string $column, ?User $user = null)
    {
        if ($column != 'likes' && $column != 'views' && $column != 'favs') {
            throw new \Exception('getDataFromUserScript 1 parameter can only have one of three values. Given value does not match any of them');
        }

        $rules = $this->makeArrayOfRules();
        $rules_filled = $this->populateWithSumOfLikes($rules, $column, ($user ? $user : user()));

        return collect($this->convertMonthNumberToName($rules_filled));
    }

    /**
     * @return array
     */
    public function makeArrayOfRules(): array
    {
        return array_map(function ($i) {
            return [
                'month' => now()->subMonths($i - 1)->month,
                'from' => now()->subMonths($i),
                'to' => now()->subMonths($i - 1),
                'sum' => 0,
            ];
        }, [12, 11, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1]);
    }

    /**
     * @param array $rules
     * @param string $column
     * @param User $user
     * @return array
     */
    public function populateWithSumOfLikes(array $rules, string $column, User $user): array
    {
        $recipes = $user->recipes()->where('created_at', '>=', now()->subYear())->get();

        foreach ($rules as $key => $rule) {
            $rules[$key]['sum'] += $recipes->map(function ($recipe) use ($rule, $column) {
                return $recipe[$column]
                    ->where('created_at', '>=', $rule['from'])
                    ->where('created_at', '<=', $rule['to'])
                    ->count();
            })->sum();
        }
        return $rules;
    }

    /**
     * Convert month number to month name
     * @param array $rules
     * @return Collection
     */
    public function convertMonthNumberToName(array $rules): Collection
    {
        return collect($rules)->map(function ($rule) {
            $rule['month'] = trans("date.month_{$rule['month']}");
            return $rule;
        });
    }
}
