<?php

namespace Tests\Feature\Repos;

use Tests\TestCase;
use App\Models\Help;
use App\Repos\HelpRepo;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HelpRepoTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var \App\Repos\HelpRepo $repo
     */
    private $repo;

    /**
     * @author Cho
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->repo = new HelpRepo;
    }

    /**
     * @author Cho
     * @test
     */
    public function getCache_method_returns_all_help_records_from_db(): void
    {
        create(Help::class);
        $result = $this->repo->getCache();

        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('id', $result[0]);
        $this->assertArrayHasKey(_('title'), $result[0]);
        $this->assertArrayHasKey('help_category_id', $result[0]);
    }
}
