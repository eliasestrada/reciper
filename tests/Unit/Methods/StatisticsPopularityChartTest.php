<?php

namespace Tests\Unit\Methods;

use App\Http\Controllers\Api\StatisticsController;
use App\Models\Recipe;
use App\Models\View;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;
use Tests\TestCase;

class StatisticsPopularityChartTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function try_to_use_mockery(): void
    {
        $mock = \Mockery::mock('\App\Models\Recipe');
        $mock->shouldReceive('ingredientsWithListItems')->once()->andReturn(['test']);
        $this->assertEquals(['test'], $mock->ingredientsWithListItems());
    }

    /** @test */
    public function script_returns_collection_with_12_months_in_it(): void
    {
        $script = (new StatisticsController)->getDataFromUserScript('likes', create_user());

        $this->assertInstanceOf(Collection::class, $script);
        $this->assertCount(12, $script);
        $script->each(function ($chart_data) {
            $this->assertArrayHasKey('month', $chart_data);
        });
    }

    /** @test */
    public function script_returns_month_names_from_latest_to_newest(): void
    {
        $script = (new StatisticsController)->getDataFromUserScript('likes', create_user());

        for ($i = 0, $sub_month = 11; $i < $script->count(); $i++, $sub_month--) {
            $month_number = now()->subMonths($sub_month)->month;
            $month_name = trans("date.month_$month_number");
            $this->assertEquals($month_name, $script[$i]['month']);
        }
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function script_throws_exception_if_first_parameter_is_not_eccepteble(): void
    {
        $script = (new StatisticsController)->getDataFromUserScript('something', create_user());
        $this - assertInstanceOf(Collection::class, $script);
    }

    /** @test */
    public function first_param_can_have_one_of_three_values(): void
    {
        $user = create_user();
        array_map(function ($param) use ($user) {
            $script = (new StatisticsController)->getDataFromUserScript($param, $user);
            $this->assertInstanceOf(Collection::class, $script);
        }, ['likes', 'views', 'favs']);
    }

    /** @test */
    public function script_returns_amount_of_needed_column_grouped_by_months(): void
    {
        $user = create_user();
        $recipes = create(Recipe::class, ['user_id' => $user->id], 5);
        $visitor = create(Visitor::class);

        View::insert([
            ['recipe_id' => $recipes[0]->id, 'visitor_id' => $visitor->id, 'created_at' => now()->subWeeks(1)],
            ['recipe_id' => $recipes[1]->id, 'visitor_id' => $visitor->id, 'created_at' => now()->subHour()],
            ['recipe_id' => $recipes[2]->id, 'visitor_id' => $visitor->id, 'created_at' => now()->subMonth()->subWeeks(2)],
            ['recipe_id' => $recipes[3]->id, 'visitor_id' => $visitor->id, 'created_at' => now()->subMonth()->subWeeks(3)],
            ['recipe_id' => $recipes[4]->id, 'visitor_id' => $visitor->id, 'created_at' => now()->subMonths(4)->subWeek()],
        ]);

        $script = (new StatisticsController)->getDataFromUserScript('views', $user);

        $this->assertEquals(2, $script->last()['sum']);
        $this->assertEquals(2, $script[10]['sum']);
        $this->assertEquals(1, $script[7]['sum']);

        $this->assertEquals(5, $script->sum('sum'));
    }

    /** @test */
    public function script_returns_sum_of_null_if_no_favs_were_found_for_this_user(): void
    {
        $other_user = create_user();

        View::create([
            'recipe_id' => create(Recipe::class, ['user_id' => $other_user])->id,
            'visitor_id' => create(Visitor::class)->id,
            'created_at' => now(),
        ]);

        $script = (new StatisticsController)->getDataFromUserScript('views', create_user());
        $this->assertEquals(0, $script->sum('sum'));
    }
}
