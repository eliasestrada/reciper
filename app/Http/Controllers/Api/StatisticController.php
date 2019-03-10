<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Responses\Controllers\Api\StatisticsPopularityChartResponse;

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
     * Give respons with Chart.js array data
     *
     * @return \App\Http\Responses\Controllers\Api\StatisticsPopularityChartResponse
     */
    public function popularityChart(): StatisticsPopularityChartResponse
    {
        return new StatisticsPopularityChartResponse([
            'views' => $this->getDataFromUser('views'),
            'likes' => $this->getDataFromUser('likes'),
            'favs' => $this->getDataFromUser('favs'),
        ]);
    }

    /**
     * Function helper that looks for all data for statistics
     *
     * @param string $column
     * @param \App\Models\User|null $user
     * @return array
     */
    public function getDataFromUser(string $column, ?User $user = null): array
    {
        if (!in_array($column, ['likes', 'views', 'favs'])) {
            $msg = 'getDataFromUser 1 parameter can only have one of three values. Given value does not match any of them';
            throw new Exception($msg);
        }

        $rules = $this->generateMonthsDataArray();

        $recipes = ($user ?? user())
            ->recipes()
            ->where('created_at', '>=', now()->subYear())
            ->get();

        foreach ($rules as $key => $rule) {
            $rules[$key]['sum'] += $recipes->map(function ($recipe) use ($rule, $column) {
                return $recipe[$column]
                    ->where('created_at', '>=', $rule['from'])
                    ->where('created_at', '<=', $rule['to'])
                    ->count();
            })->sum();
        }

        return $this->convertMonthNumberToName($rules);
    }

    /**
     * Convert month number to month name
     *
     * @param array $rules
     * @return array
     */
    public function convertMonthNumberToName(array $rules): array
    {
        return array_map(function ($rule) {
            $rule['month'] = trans("date.month_{$rule['month']}");
            return $rule;
        }, $rules);
    }

    /**
     * @return array
     */
    public function generateMonthsDataArray(): array
    {
        return array_map(function ($num) {
            return [
                'month' => now()->startOfMonth()->subMonths($num - 1)->month,
                'from' => now()->startOfMonth()->subMonths($num - 1)->toDateString(),
                'to' => now()->startOfMonth()->subMonths($num - 2)->toDateString(),
                'sum' => 0,
            ];
        }, [12, 11, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1]);
    }
}
