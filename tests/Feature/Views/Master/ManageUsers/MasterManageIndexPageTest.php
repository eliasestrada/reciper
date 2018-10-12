<?php

namespace Tests\Feature\Views\Master\Visitors;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MasterManageUsersIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    private $master;

    public function setUp()
    {
        parent::setUp();

        $this->master = create_user('master');
    }

    /** @test */
    public function master_can_view_the_page(): void
    {
        $this->actingAs($this->master)
            ->get('/master/manage-users')
            ->assertOk();
    }

    /** @test */
    public function admin_and_user_cant_view_the_page(): void
    {
        $this->actingAs(create_user('admin'))
            ->get('/master/manage-users')
            ->assertRedirect();

        $this->actingAs(make(User::class))
            ->get('/master/manage-users')
            ->assertRedirect();
    }

    /** @test */
    public function view_has_data(): void
    {
        $this->actingAs($this->master)
            ->get('/master/manage-users')
            ->assertViewIs('master.manage-users.index')
            ->assertViewHasAll(['users', 'active']);
    }
}
