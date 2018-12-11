<?php

namespace Tests\Unit\Repos;

use App\Models\Meal;
use App\Repos\MealRepo;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class MealRepoTest extends TestCase
{
    public $meal_repo;

    /**
     * @author Cho
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->meal_repo = new MealRepo;
    }

    /**
     * @author Cho
     * @test
     */
    public function method_All_returns_whole_collection(): void
    {
        $keys = ['id', 'name_' . LANG()];

        $this->assertEquals(Meal::count(), $this->meal_repo->all()->count());

        array_walk($keys, function ($key) {
            $this->assertArrayHasKey($key, $this->meal_repo->all()->first()->toArray());
        });
    }

    /**
     * @author Cho
     * @test
     */
    public function getWithCache_method_returs_array_of_cached_meal_list()
    {
        cache()->forget('meal');
        $this->meal_repo->getWithCache();

        $list = cache()->get('meal');

        $this->assertCount(3, cache()->get('meal'));
        $this->assertEquals(trans('home.breakfast'), $list[0]['name']);
        $this->assertEquals(trans('home.lunch'), $list[1]['name']);
        $this->assertEquals(trans('home.dinner'), $list[2]['name']);
    }
}
