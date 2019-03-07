<?php

namespace Tests\Unit\Controllers\Statistics;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Collection;
use App\Http\Controllers\Api\StatisticController;

class StatisticsPopularityChartTest extends TestCase
{
    /**
     * @test
     */
    public function getDataFromUser_throws_exception_if_first_parameter_is_not_acceptable(): void
    {
        $this->expectException(\Exception::class);

        $method = (new StatisticController)->getDataFromUser('something', make(User::class));
        $this->assertInstanceOf(Collection::class, $method);
    }

    /**
     * @test
     */
    public function getDataFromUser_method_first_param_can_have_one_of_three_values(): void
    {
        $user = make(User::class);
        array_map(function ($param) use ($user) {
            $method = (new StatisticController)->getDataFromUser($param, $user);
            $this->assertInstanceOf(Collection::class, $method);
        }, ['likes', 'views', 'favs']);
    }

    /**
     * @test
     */
    public function getDataFromUser_returns_month_names_from_latest_to_newest(): void
    {
        $method = (new StatisticController)->getDataFromUser('likes', make(User::class));

        for ($i = 0, $sub_month = 11; $i < $method->count(); $i++, $sub_month--) {
            $month_number = now()->startOfMonth()->subMonths($sub_month)->month;
            $month_name = trans("date.month_{$month_number}");
            $this->assertEquals($month_name, $method[$i]['month']);
        }
    }

    /**
     * @test
     */
    public function getDataFromUser_returns_sum_of_null_if_no_favs_were_found_for_this_user(): void
    {
        $method = (new StatisticController)->getDataFromUser('views', make(User::class));
        $this->assertEquals(0, $method->sum('sum'));
    }

    /**
     * @test
     */
    public function makeArrayOfRules_method_generates_rules_list(): void
    {
        $method = (new StatisticController)->makeArrayOfRules();
        $keys = ['month', 'from', 'to', 'sum'];

        $this->assertTrue(is_array($method));

        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $method[0]);
        }
    }

    /**
     * In $expect variable we need to subtract 11 on the first lap, 10 on the second etc
     * That's why I'm adding month and then subtract months on this lap
     * @test
     * */
    public function makeArrayOfRules_contains_12_months_from_from_this_month(): void
    {
        $method = (new StatisticController)->makeArrayOfRules();
        $months = [12, 11, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1];

        foreach ($months as $key => $month) {
            $expect = now()->startOfMonth()->addMonth()->subMonths($month)->month;
            $actual = $method[$key]['month'];
            $this->assertEquals($expect, $actual, ">>> KEY IS {$key}\n");
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
        $result = (new StatisticController)->convertMonthNumberToName($months);

        foreach ($result->pluck('month') as $key => $actual) {
            $expect = trans('date.month_' . $months[$key]['month']);
            $this->assertEquals($expect, $actual, ">>> KEY IS {$key}");
        }
    }
}
