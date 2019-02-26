<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Meal;

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
        $meal = make(Meal::class, [_('name') => 'dinner']);
        $this->assertEquals('dinner', $meal->getName());
    }
}
