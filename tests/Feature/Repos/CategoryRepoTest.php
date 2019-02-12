<?php

namespace Tests\Feature\Repos;

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
    public function get_method_returns_all_category_records_from_db(): void
    {
        $result = CategoryRepo::get();
        $this->assertTrue(is_object($result));
        $this->assertInstanceOf(Collection::class, $result);
    }
}
