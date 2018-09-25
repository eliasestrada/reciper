<?php

namespace Tests\Feature\Views\Master\Visitors;

use App\Models\Ban;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MasterVisitorsShowPageTest extends TestCase
{
    use DatabaseTransactions;

    public $master;
    public $visitor;

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

    /** @test */
    public function master_can_ban_visitor(): void
    {
        $this->actingAs($this->master)
            ->followingRedirects()
            ->put(action('Master\VisitorsController@update', ['id' => $this->visitor->id]), [
                'days' => 1,
                'message' => 'Lorem ipsum dolor sit amet consectetur adipisicing simalunus ago',
            ])
            ->assertSee(trans('visitors.visitor_banned', ['days' => 1]));

        $this->assertDatabaseHas('ban', [
            'visitor_id' => $this->visitor->id,
            'days' => 1,
            'message' => 'Lorem ipsum dolor sit amet consectetur adipisicing simalunus ago',
        ]);
    }

    /** @test */
    public function master_can_see_ban_btn_and_doesnt_see_unban_btn_when_visitor_is_not_banned(): void
    {
        $this->actingAs($this->master)
            ->get("/master/visitors/{$this->visitor->id}")
            ->assertSee('<i class="fas fa-lock left"></i> ' . trans('visitors.ban'))
            ->assertDontSee('<i class="fas fa-lock-open left"></i> ' . trans('visitors.unban'));
    }

    /** @test */
    public function master_can_see_unban_btn_and_doesnt_see_ban_btn_when_visitor_is_banned(): void
    {
        Ban::banVisitor($this->visitor->id, 1, 'Some message');

        $this->actingAs($this->master)
            ->get("/master/visitors/{$this->visitor->id}")
            ->assertDontSee('<i class="fas fa-lock left"></i> ' . trans('visitors.ban'))
            ->assertSee('<i class="fas fa-lock-open left"></i> ' . trans('visitors.unban'));
    }

    /** @test */
    public function master_cant_ban_visitor_without_message(): void
    {
        $this->actingAs($this->master)
            ->followingRedirects()
            ->put(action('Master\VisitorsController@update', ['id' => $this->visitor->id]), [
                'days' => 2,
            ])
            ->assertDontSee(trans('visitors.visitor_banned', ['days' => 1]));

        $this->assertDatabaseMissing('ban', [
            'visitor_id' => $this->visitor->id,
            'days' => 2,
        ]);
    }
}
