<?php

namespace Tests\Feature\Views\Master\ManageUsers;

use App\Models\Ban;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MasterManageUsersShowPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var \App\Models\User
     */
    private $user;

    /**
     * Setup the test environment
     * 
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->user = create(User::class);
    }

    /**
     * @test
     */
    public function master_can_see_the_page(): void
    {
        $this->actingAs(create_user('master'))
            ->get("/master/manage-users/{$this->user->id}")
            ->assertViewIs('master.manage-users.show');
    }

    /**
     * @test
     */
    public function admin_cant_view_the_page(): void
    {
        $this->actingAs(create_user('admin'))
            ->get("/master/manage-users/{$this->user->id}")
            ->assertRedirect();
    }

    /**
     * @test
     */
    public function user_cant_view_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get("/master/manage-users/{$this->user->id}")
            ->assertRedirect();
    }

    /**
     * @test
     */
    public function master_can_ban_user(): void
    {
        $data = ['days' => 1, 'message' => string_random(40)];

        $this->actingAs(create_user('master'))
            ->put(action('Master\ManageUserController@update', [
                'id' => $this->user->id,
            ]), $data);

        $this->assertDatabaseHas('ban', [
            'user_id' => $this->user->id,
            'days' => $data['days'],
            'message' => $data['message'],
        ]);
    }

    /**
     * @test
     */
    public function master_can_unban_user(): void
    {
        Ban::put($this->user->id, 2, 'This user is banned on 2 days');

        $this->actingAs(create_user('master'))
            ->delete(action('Master\ManageUserController@destroy', [
                'user' => $this->user->id,
            ]));

        $this->assertDatabaseMissing('ban', ['user_id' => $this->user->id]);
    }
}
