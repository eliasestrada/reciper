<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Repos\RecipeRepo;
use App\Http\Controllers\Controller;
use App\Http\Responses\Controllers\Api\StatisticsPopularityChartResponse;

class StatisticController extends Controller
{
    /**
     * @var \Illuminate\Support\Collection
     */
    private $recipes;

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
     * @param \App\Repos\RecipeRepo $recipe_repo
     * @param int|null $user_id
     * @return \App\Http\Responses\Controllers\Api\StatisticsPopularityChartResponse
     */
    public function popularityChart(RecipeRepo $recipe_repo, ?int $user_id = null): StatisticsPopularityChartResponse
    {
        /**
         * @todo This query should bee cached
         * Also there should be a timer that shows when stats will update
         */
        $this->recipes = $recipe_repo->getCachedUserRecipesForTheLastYear(
            $user_id ?? user()->id
        );

        $rules = $this->generateRulesArray();

        return new StatisticsPopularityChartResponse([
            'views' => $this->generateArrayWithChartData('views', $rules),
            'likes' => $this->generateArrayWithChartData('likes', $rules),
            'favs' => $this->generateArrayWithChartData('favs', $rules),
        ]);
    }

    /**
     * @return array
     */
    public function generateRulesArray(): array
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

    /**
     * @param string $column
     * @param array $rules
     * @return array
     */
    public function generateArrayWithChartData(string $column, array $rules): array
    {
        if (!in_array($column, ['likes', 'views', 'favs'])) {
            $msg = 'getDataFromUser 1 parameter can only have one of three values. Given value does not match any of them';
            throw new Exception($msg);
        }

        // Takes rules array and fills out the 'sum' column with data from database
        foreach ($rules as $key => $rule) {
            $rules[$key]['sum'] += $this->recipes->map(function ($recipe) use ($rule, $column) {
                return $recipe[$column]
                    ->where('created_at', '>=', $rule['from'])
                    ->where('created_at', '<=', $rule['to'])
                    ->count();
            })->sum();
        }

        return $this->convertMonthNumberToName($rules);
    }

    /**
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
}
