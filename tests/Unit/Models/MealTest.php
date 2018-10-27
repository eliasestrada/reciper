<?php

namespace Tests\Unit\Models;

use App\Models\Meal;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class MealTest extends TestCase
{
    /**
     * @author Cho
     * @test
     */
    public function meal_model_has_attributes(): void
    {
        array_map(function ($attr) {
            $this->assertClassHasAttribute($attr, Meal::class);
        }, ['table', 'guarded', 'timestamps']);
    }

    /**
     * @author Cho
     * @test
     */
    public function getName_method_returns_name_column_from_database(): void
    {
        $meal = make(Meal::class, ['name_' . LANG() => 'dinner']);
        $this->assertEquals('dinner', $meal->getName());
    }

    /**
     * @author Cho
     * @test
     */
    public function getWithCache_method_returs_array_of_cached_meal_list()
    {
        cache()->forget('meal');
        Meal::getWithCache();

        $list = cache()->get('meal');
        $this->assertCount(3, cache()->get('meal'));
        $this->assertEquals(trans('home.breakfast'), $list[0]['name']);
        $this->assertEquals(trans('home.lunch'), $list[1]['name']);
        $this->assertEquals(trans('home.dinner'), $list[2]['name']);
    }
}
