<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\Controllers\Api\StatisticsPopularityChartResponse;
use App\Models\User;
use Illuminate\Support\Collection;

class StatisticsController extends Controller
{
    /**
     * Chart.js
     */
    public function popularityChart()
    {
        $chart_data = [
            'views' => $this->getDataFromUser('views'),
            'likes' => $this->getDataFromUser('likes'),
            'favs' => $this->getDataFromUser('favs'),
        ];

        return new StatisticsPopularityChartResponse($chart_data);
    }

    /**
     * @param string $column
     * @param User|null $user this param for testing purposes, coz I can just use auth()->user helper
     * @return Collection
     */
    public function getDataFromUser(string $column, ?User $user = null): Collection
    {
        if ($column != 'likes' && $column != 'views' && $column != 'favs') {
            throw new \Exception('getDataFromUser 1 parameter can only have one of three values. Given value does not match any of them');
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
        return array_map(function ($month_number) {
            return [
                'month' => now()->startOfMonth()->subMonths($month_number - 1)->month,
                'from' => now()->startOfMonth()->subMonths($month_number - 1),
                'to' => now()->startOfMonth()->subMonths($month_number - 2),
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
