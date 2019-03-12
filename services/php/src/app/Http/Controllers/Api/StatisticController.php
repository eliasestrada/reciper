<?php

namespace App\Http\Controllers\Api;

use App\Repos\RecipeRepo;
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
     * @param \App\Repos\RecipeRepo $recipe_repo
     * @param int|null $user_id
     * @return \App\Http\Responses\Controllers\Api\StatisticsPopularityChartResponse
     */
    public function popularityChart(RecipeRepo $recipe_repo, ?int $user_id = null): StatisticsPopularityChartResponse
    {
        return new StatisticsPopularityChartResponse(
            $recipe_repo->getUserRecipesForTheLastYear($user_id ?? user()->id)
        );
    }
}
