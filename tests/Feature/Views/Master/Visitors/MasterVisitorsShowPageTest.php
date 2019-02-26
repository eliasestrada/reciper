<?php

namespace Tests\Feature\Views\Master\Visitors;

use Tests\TestCase;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MasterVisitorsShowPageTest extends TestCase
{
    use DatabaseTransactions;

    private $visitor;

    /**
     * @author Cho
     */
    public function setUp()
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
