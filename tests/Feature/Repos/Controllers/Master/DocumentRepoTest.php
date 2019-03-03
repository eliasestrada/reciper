<?php

namespace Tests\Feature\Repos\Controllers\Master;

use Tests\TestCase;
use App\Repos\Controllers\Master\DocumentRepo;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DocumentRepoTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var \App\Repos\Controllers\Master\DocumentRepo $repo
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
        $this->repo = new DocumentRepo;
    }

    /**
     * @author Cho
     * @test
     */
    public function test(): void
    {
        $this->markTestIncomplete();
    }
}
