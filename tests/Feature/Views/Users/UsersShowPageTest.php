<?php

namespace Tests\Feature\Views\Users;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UsersShowPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_has_data(): void
    {
        $this->actingAs($user = create_user())->get("/users/$user->username")
            ->assertViewIs('users.show')
            ->assertViewHasAll(['recipes', 'user', 'xp']);
    }

    /** @test */
    public function auth_user_can_see_the_page(): void
    {
        $user = create_user();
        $this->actingAs($user)->get("/users/$user->username")->assertOk();
    }

    /** @test */
    public function guest_can_see_users_show_page(): void
    {
        $user = create_user();
        $this->get("/users/$user->username")->assertOk();
    }

    /** @test */
    public function noone_can_see_user_page_after_diactivating(): void
    {
        $user = create_user('', ['active' => 0]);

        $this->get("/users/$user->username")->assertSeeText(trans('users.user_is_not_active'));
    }
}
