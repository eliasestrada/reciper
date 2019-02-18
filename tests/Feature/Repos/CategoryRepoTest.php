<?php

namespace Tests\Feature\Repos;

use App\Models\Category;
use App\Repos\CategoryRepo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;
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
        $this->assertInstanceOf(Collection::class, CategoryRepo::get());
    }

    /**
     * @author Cho
     * @test
     */
    public function get_method_returns_all_categories_from_db(): void
    {
        $this->assertCount(Category::count(), CategoryRepo::get());
    }
}
