<?php

namespace Tests\Feature\Views\Master\Visitors;

use Tests\TestCase;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MasterVisitorsShowPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var \App\Models\Visitor $visitor
     */
    private $visitor;

    /**
     * Setup the test environment
     * 
     * @author Cho
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->visitor = create(Visitor::class);
    }

    /**
     * @author Cho
     * @test
     */
    public function master_can_see_the_page(): void
    {
        $this->actingAs(create_user('master'))
            ->get("/master/visitors/{$this->visitor->id}")
            ->assertViewIs('master.visitors.show')
            ->assertOk();
    }

    /**
     * @author Cho
     * @test
     */
    public function admin_cant_see_the_page(): void
    {
        $this->actingAs(create_user('admin'))
            ->get("/master/visitors/{$this->visitor->id}")
            ->assertRedirect();
    }

    /**
     * @author Cho
     * @test
     */
    public function user_cant_see_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get("/master/visitors/{$this->visitor->id}")
            ->assertRedirect();
    }
}
