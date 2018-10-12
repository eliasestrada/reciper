<?php

namespace Tests\Feature\Views\Master\Visitors;

use App\Models\User;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MasterVisitorsShowPageTest extends TestCase
{
    use DatabaseTransactions;

    private $master;
    private $visitor;

    public function setUp()
    {
        parent::setUp();

        $this->master = create_user('master');
        $this->visitor = create(Visitor::class);
    }

    /** @test */
    public function master_can_view_the_page(): void
    {
        $this->actingAs($this->master)
            ->get("/master/visitors/{$this->visitor->id}")
            ->assertOk();

    }

    /** @test */
    public function admin_and_user_cant_view_the_page(): void
    {
        $this->actingAs(create_user('admin'))
            ->get("/master/visitors/{$this->visitor->id}")
            ->assertRedirect();

        $this->actingAs(make(User::class))
            ->get("/master/visitors/{$this->visitor->id}")
            ->assertRedirect();
    }

    /** @test */
    public function view_has_data(): void
    {
        $this->actingAs($this->master)
            ->get("/master/visitors/{$this->visitor->id}")
            ->assertViewIs('master.visitors.show')
            ->assertViewHasAll([
                'visitor' => Visitor::with('likes')
                    ->with('views')
                    ->with('user')
                    ->whereId($this->visitor->id)
                    ->first(),
            ]);
    }
}
