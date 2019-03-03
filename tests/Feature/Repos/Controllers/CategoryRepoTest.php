<?php

namespace Tests\Feature\Repos\Controllers;

use Tests\TestCase;
use App\Models\Category;
use App\Repos\Controllers\CategoryRepo;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryRepoTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var \App\Repos\Controllers\CategoryRepo $repo
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
        $this->repo = new CategoryRepo;
    }

    /**
     * @author Cho
     * @test
     */
    public function get_method_returns_collection(): void
    {
        $this->assertTrue(is_array($this->repo->getAllInArray()));
    }

    /**
     * @author Cho
     * @test
     */
    public function get_method_returns_all_categories_from_db(): void
    {
        $this->assertCount(Category::count(), $this->repo->getAllInArray());
    }
}
