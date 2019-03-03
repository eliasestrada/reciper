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
    public function method_getCache_returns_all_categories_from_db(): void
    {
        $this->assertCount(Category::count(), $this->repo->getCache());
    }

    /**
     * @author Cho
     * @test
     */
    public function method_getCache_returns_cache(): void
    {
        $this->repo->getCache();
        $this->assertCount(Category::count(), cache()->get('categories'));
    }
}
