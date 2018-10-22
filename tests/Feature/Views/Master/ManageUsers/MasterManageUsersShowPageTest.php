<?php

namespace Tests\Feature\Views\Master\ManageUsers;

use App\Models\Ban;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MasterManageUsersShowPageTest extends TestCase
{
    use DatabaseTransactions;

    private $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = create(User::class);
    }

    /** @test */
    public function view_has_data(): void
    {
        $this->actingAs(create_user('master'))
            ->get("/master/manage-users/{$this->user->id}")
            ->assertViewIs('master.manage-users.show')
            ->assertViewHas('user');
    }

    /** @test */
    public function admin_cant_view_the_page(): void
    {
        $this->actingAs(create_user('admin'))
            ->get("/master/manage-users/{$this->user->id}")
            ->assertRedirect();
    }

    /** @test */
    public function user_cant_view_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get("/master/manage-users/{$this->user->id}")
            ->assertRedirect();
    }

    /** @test */
    public function master_can_ban_user(): void
    {
        $data = ['days' => 1, 'message' => str_random(40)];

        $this->actingAs(create_user('master'))
            ->put(action('Master\ManageUsersController@update', [
                'id' => $this->user->id,
            ]), $data);

        $this->assertDatabaseHas('ban', [
            'user_id' => $this->user->id,
            'days' => $data['days'],
            'message' => $data['message'],
        ]);
    }

    /** @test */
    public function master_can_see_ban_btn_and_doesnt_see_unban_btn_when_user_is_not_banned(): void
    {
        $this->actingAs(create_user('master'))
            ->get("/master/manage-users/{$this->user->id}")
            ->assertSee('<i class="fas fa-lock left"></i> ' . trans('manage-users.ban'))
            ->assertDontSee('<i class="fas fa-lock-open left"></i> ' . trans('manage-users.unban'));
    }

    /** @test */
    public function master_can_see_unban_btn_and_doesnt_see_ban_btn_when_user_is_banned(): void
    {
        Ban::put($this->user->id, 1, 'Some message');

        $this->actingAs(create_user('master'))
            ->get("/master/manage-users/{$this->user->id}")
            ->assertDontSee('<i class="fas fa-lock left"></i> ' . trans('manage-users.ban'))
            ->assertSee('<i class="fas fa-lock-open left"></i> ' . trans('manage-users.unban'));
    }

    /** @test */
    public function master_can_unban_user(): void
    {
        Ban::put($this->user->id, 2, 'This user is banned on 2 days');

        $this->actingAs(create_user('master'))
            ->delete(action('Master\ManageUsersController@destroy', ['id' => $this->user->id]));

        $this->assertDatabaseMissing('ban', ['user_id' => $this->user->id]);
    }
}
