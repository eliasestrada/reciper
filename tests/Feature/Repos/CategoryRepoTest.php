<?php

namespace Tests\Feature\Repos;

use App\Models\Category;
use App\Repos\CategoryRepo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CategoryRepoTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @author Cho
     * @test
     */
    public function get_method_returns_collection(): void
    {
        $this->assertTrue(is_array((new CategoryRepo)->getAllInArray()));
    }

    /**
     * @author Cho
     * @test
     */
    public function get_method_returns_all_categories_from_db(): void
    {
        $this->assertCount(Category::count(), (new CategoryRepo)->getAllInArray());
    }
}
