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
     * Setup the test environment
     * 
     * @author Cho
     * @return void
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
    public function method_getCache_returns_all_help_records_from_db(): void
    {
        create(Help::class);
        $result = $this->repo->getCache();

        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('id', $result[0]);
        $this->assertArrayHasKey(_('title'), $result[0]);
        $this->assertArrayHasKey('help_category_id', $result[0]);
    }
    
    /**
     * @author Cho
     * @test
     */
    public function method_find_returns_help_article_with_given_id(): void
    {
        $help = create(Help::class);
        $result = $this->repo->find($help->id);
        $this->assertEquals($help->toBase(), $result->toBase());
    }
}
