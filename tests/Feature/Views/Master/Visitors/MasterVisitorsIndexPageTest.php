<?php

namespace Tests\Feature\Views\Master\Visitors;

use App\Models\User;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MasterVisitorsIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    public $master;

    public function setUp()
    {
        parent::setUp();

        $this->master = create_user('master');
    }

    /** @test */
    public function master_can_view_the_page(): void
    {
        $this->actingAs($this->master)
            ->get('/master/visitors')
            ->assertOk();
    }

    /** @test */
    public function admin_and_user_cant_view_the_page(): void
    {
        $this->actingAs(create_user('admin'))
            ->get('/master/visitors')
            ->assertRedirect();

        $this->actingAs(make(User::class))
            ->get('/master/visitors')
            ->assertRedirect();
    }

    /** @test */
    public function view_has_data(): void
    {
        $this->actingAs($this->master)
            ->get('/master/visitors')
            ->assertViewIs('master.visitors.index')
            ->assertViewHas('visitors',
                Visitor::withCount('views')
                    ->with('likes')
                    ->with('views')
                    ->with('user')
                    ->orderBy('views_count', 'desc')
                    ->paginate(50)
                    ->onEachSide(1)
            );
    }
}
