<?php

namespace Tests\Unit\Responses\Api;

use Exception;
use Tests\TestCase;
use App\Http\Responses\Controllers\Api\StatisticsPopularityChartResponse;
use App\Models\User;

class StatisticsPopularityChartResponseTest extends TestCase
{
    /**
     * @var \App\Http\Responses\Controllers\Api\StatisticsPopularityChartResponse
     */
    private $class;

    /**
     * Setup the test environment
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $user = make(User::class);
        $this->class = new StatisticsPopularityChartResponse(collect(), $user->id);
    }

    /**
     * @test
     */
    public function getDataFromUser_throws_exception_if_first_parameter_is_not_acceptable(): void
    {
        $this->expectException(Exception::class);
        $this->class->generateArrayWithChartData('something', []);
    }

    /**
     * In $expect variable we need to subtract 11 on the first lap, 10 on the second etc
     * That's why I'm adding month and then subtract months on this lap
     * 
     * @test
     */
    public function generateRulesArray_contains_12_months_from_from_current_month(): void
    {
        $method = $this->class->generateRulesArray();
        $months_of_the_year = [12, 11, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1];

        foreach ($months_of_the_year as $key => $month) {
            $expect = now()->startOfMonth()->addMonth()->subMonths($month)->month;
            $actual = $method[$key]['month'];
            $this->assertEquals($expect, $actual);
        }
    }

    /**
     * @test
     */
    public function generateRulesArray_contains_12_month_dates_starting_from_current_to_latest_date_in_current_year(): void
    {
        $method = $this->class->generateRulesArray();
        $months_of_the_year = [12, 11, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1];

        foreach ($months_of_the_year as $key => $month) {
            $expect = now()->startOfMonth()->addMonth()->subMonths($month)->toDateString();
            $actual = $method[$key]['from'];
            $this->assertEquals($expect, $actual);
        }
    }

    /**
     * @test
     */
    public function convertMonthNumberToName_method_converts_date(): void
    {
        $months = [
            ['month' => 12], ['month' => 11], ['month' => 10], ['month' => 9],
            ['month' => 8], ['month' => 7], ['month' => 6], ['month' => 5],
            ['month' => 4], ['month' => 3], ['month' => 2], ['month' => 1],
        ];

        $result = $this->class->convertMonthNumberToName($months);

        foreach (array_column($result, 'month') as $key => $actual) {
            $expect = trans("date.month_{$months[$key]['month']}");
            $this->assertEquals($expect, $actual);
        }
    }
}
