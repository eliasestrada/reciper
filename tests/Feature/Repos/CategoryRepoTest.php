<?php

namespace Tests\Feature\Repos;

use Tests\TestCase;
use App\Models\Category;
use App\Repos\CategoryRepo;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryRepoTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var \App\Repos\CategoryRepo $repo
     */
    private $repo;

    /**
     * @author Cho
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
