<?php

namespace Tests\Feature\Views\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UsersShowPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * resources/views/users/show
     * @test
     * @return void
     */
    public function viewUsersShowHasData(): void
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get("/users/$user->id")
            ->assertViewIs('users.show')
            ->assertViewHasAll(['recipes', 'user', 'likes']);
    }

    /**
     * resources/view views/users/show
     * @test
     * @return void
     */
    public function authUserCanSeeUsersShowPage(): void
    {
        $user = factory(User::class)->make();
        $this->actingAs($user)->get('/users/' . $user->id)->assertOk();
    }

    /**
     * resources/views/users/show
     * @test
     * @return void
     */
    public function guestCanSeeUsersShowPage(): void
    {
        $user = factory(User::class)->make();
        $this->get("/users/$user->id")->assertOk();
    }
}
