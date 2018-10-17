<?php

namespace Tests\Feature\Views\Users;

use App\Http\Controllers\UsersController;
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

    /** @test */
    public function user_sees_activate_account_form_when_is_not_active(): void
    {
        $user = create_user('', ['active' => 0]);

        $this->actingAs($user)
            ->get("/users/$user->username")
            ->assertSee(trans('users.activate_account_desc', [
                'days' => 30 - (date('j') - $user->updated_at->format('j')),
            ]));
    }

    /** @test */
    public function user_does_not_see_activate_account_form_when_is_active(): void
    {
        $user = create_user();

        $this->actingAs($user)
            ->get("/users/$user->username")
            ->assertDontSee(trans('users.activate_account_desc', [
                'days' => 30 - (date('j') - $user->updated_at->format('j')),
            ]));
    }

    /** @test */
    public function unactive_user_can_recover_account(): void
    {
        $user = create_user('', ['active' => 0]);

        $this->actingAs($user)
            ->post(action([UsersController::class, 'store']))
            ->assertRedirect("/users/$user->username");

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'active' => 1,
        ]);
    }
}
