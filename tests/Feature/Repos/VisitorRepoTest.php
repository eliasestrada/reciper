<?php

namespace Tests\Feature\Repos;

use Tests\TestCase;
use App\Models\Visitor;
use App\Repos\VisitorRepo;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VisitorRepoTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var \App\Repos\VisitorRepo $repo
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
        $this->repo = new VisitorRepo;
    }

    /**
     * @test
     */
    public function method_getVisitorId_returns_only_id_of_the_visitor_by_given_ip_address(): void
    {
        $visitor = create(Visitor::class);
        $id = $this->repo->getVisitorId($visitor->ip);
        $this->assertEquals($visitor->id, $id);
    }
}