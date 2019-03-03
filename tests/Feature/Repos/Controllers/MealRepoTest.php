<?php

namespace Tests\Feature\Repos\Controllers;

use Tests\TestCase;
use App\Models\Meal;
use App\Repos\Controllers\MealRepo;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MealRepoTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var \App\Repos\Controllers\MealRepo $repo
     */
    private $repo;

    /**
     * Setup the test environment
     * 
     * @author Cho
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->repo = new MealRepo;
    }

    /**
     * @author Cho
     * @test
     */
    public function method_All_returns_whole_collection(): void
    {
        $keys = ['id', _('name')];

        $this->assertEquals(Meal::count(), $this->repo->all()->count());

        array_walk($keys, function ($key) {
            $this->assertArrayHasKey($key, $this->repo->all()->first()->toArray());
        });
    }

    /**
     * @author Cho
     * @test
     */
    public function getWithCache_method_returs_array_of_cached_meal_list()
    {
        cache()->forget('meal');
        $this->repo->getWithCache();

        $list = cache()->get('meal');

        $this->assertCount(3, cache()->get('meal'));
        $this->assertEquals(trans('home.breakfast'), $list[0][_('name')]);
        $this->assertEquals(trans('home.lunch'), $list[1][_('name')]);
        $this->assertEquals(trans('home.dinner'), $list[2][_('name')]);
    }
}
