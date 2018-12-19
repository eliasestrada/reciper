<?php

namespace App\Http\Controllers\WebApi;

use App\Http\Controllers\Controller;
use App\Http\Responses\Controllers\Api\StatisticsPopularityChartResponse;
use App\Models\User;
use Illuminate\Support\Collection;

class StatisticsController extends Controller
{
    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Give respons with Chart.js array data
     *
     * @return \App\Http\Responses\Controllers\Api\StatisticsPopularityChartResponse
     */
    public function popularityChart(): StatisticsPopularityChartResponse
    {
        $chart_data = [
            'views' => $this->getDataFromUser('views'),
            'likes' => $this->getDataFromUser('likes'),
            'favs' => $this->getDataFromUser('favs'),
        ];

        return new StatisticsPopularityChartResponse($chart_data);
    }

    /**
     * Function helper that looks for all data for statistics
     *
     * @param string $column
     * @param \App\Models\User|null $user this param for testing purposes, coz I can just use auth()->user helper
     * @return \Illuminate\Support\Collection
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
     * This helper function creates array with needed attributes
     *
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
     * Take array of rules and populate it with real data
     *
     * @param array $rules
     * @param string $column
     * @param \App\Models\User $user
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
     *
     * @param array $rules
     * @return \Illuminate\Support\Collection
     */
    public function convertMonthNumberToName(array $rules): Collection
    {
        return collect($rules)->map(function ($rule) {
            $rule['month'] = trans("date.month_{$rule['month']}");
            return $rule;
        });
    }
}
