<?php

namespace Tests\Unit\Controllers\Statistics;

use Exception;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Collection;
use App\Http\Controllers\Api\StatisticController;

class StatisticsPopularityChartTest extends TestCase
{
    /**
     * @var \App\Http\Controllers\Api\StatisticController
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
        $this->class = new StatisticController;
    }

    /**
     * @test
     */
    public function getDataFromUser_throws_exception_if_first_parameter_is_not_acceptable(): void
    {
        $this->expectException(Exception::class);

        $method = $this->class->getDataFromUser('something', make(User::class));
        $this->assertInstanceOf(Collection::class, $method);
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

        foreach ($result->pluck('month') as $key => $actual) {
            $expect = trans('date.month_' . $months[$key]['month']);
            $this->assertEquals($expect, $actual, ">>> KEY IS {$key}");
        }
    }
}
