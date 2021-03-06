<?php

namespace Tests\Feature\Repos;

use Tests\TestCase;
use App\Models\HelpCategory;
use App\Repos\HelpCategoryRepo;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HelpCategoryRepoTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var \App\Repos\HelpCategoryRepo
     */
    private $repo;

    /**
     * Setup the test environment
     * 
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->repo = new HelpCategoryRepo;
    }

    /**
     * @test
     */
    public function getCache_method_returns_all_help_category_records_from_db(): void
    {
        create(HelpCategory::class);
        $result = $this->repo->getCache();

        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('id', $result[0]);
        $this->assertArrayHasKey(_('title'), $result[0]);
        $this->assertArrayHasKey('icon', $result[0]);
    }
}
