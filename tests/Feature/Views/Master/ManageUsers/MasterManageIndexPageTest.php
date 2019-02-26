<?php

namespace Tests\Feature\Views\Master\Visitors;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MasterManageUsersIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @author Cho
     * @test
     */
    public function master_can_see_the_page(): void
    {
        $this->actingAs(create_user('master'))
            ->get('/master/manage-users')
            ->assertViewIs('master.manage-users.index');
    }

    /**
     * @author Cho
     * @test
     */
    public function admin_cant_view_the_page(): void
    {
        $this->actingAs(create_user('admin'))
            ->get('/master/manage-users')
            ->assertRedirect();
    }

    /**
     * @author Cho
     * @test
     */
    public function user_cant_view_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get('/master/manage-users')
            ->assertRedirect();
    }
}
