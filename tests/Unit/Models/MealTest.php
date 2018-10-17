<?php

namespace Tests\Unit\Models;

use App\Models\Meal;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class MealTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function model_has_attributes(): void
    {
        array_map(function ($attr) {
            $this->assertClassHasAttribute($attr, Meal::class);
        }, ['table', 'guarded', 'timestamps']);
    }

    /** @test */
    public function model_has_relationship_with_recipes(): void
    {
        $meal = Meal::find(1);
        $recipe = create(Recipe::class, [
            'meal_id' => 1,
        ], 2);

        $this->assertTrue($meal->recipes()->exists());
        $this->assertGreaterThanOrEqual(2, $meal->recipes->count());
    }

    /** @test */
    public function get_name_method_returns_name_row(): void
    {
        $actual = Meal::get(['name_' . lang()]);
        $expected = [
            trans('home.breakfast'),
            trans('home.lunch'),
            trans('home.dinner'),
        ];

        foreach ($actual as $i => $meal) {
            $this->assertEquals($meal->getName(), $expected[$i]);
        }
    }

    /** @test */
    public function get_with_cache_method_returs_array_of_cached_meal_list()
    {
        cache()->forget('meal');
        $list = Meal::getWithCache();
        $this->assertCount(3, $list);
        $this->assertCount(3, cache()->get('meal'));
        $this->assertEquals(trans('home.breakfast'), $list[0]['name']);
        $this->assertEquals(trans('home.lunch'), $list[1]['name']);
        $this->assertEquals(trans('home.dinner'), $list[2]['name']);
    }
}
