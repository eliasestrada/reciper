<?php

namespace Tests\Feature\Repos;

use App\Models\HelpCategory;
use App\Repos\HelpCategoryRepo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class HelpCategoryRepoTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @author Cho
     * @test
     */
    public function getCache_method_returns_all_help_category_records_from_db(): void
    {
        create(HelpCategory::class);
        $result = HelpCategoryRepo::getCache();

        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('id', $result[0]);
        $this->assertArrayHasKey('title', $result[0]);
        $this->assertArrayHasKey('icon', $result[0]);
    }
}
