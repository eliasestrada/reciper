<?php

namespace Tests\Feature\Views\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UsersIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * resources/views/users/index
     * @test
     * @return void
     */
    public function viewUsersIndexHasData(): void
    {
        $user = factory(User::class)->make();

        $this->actingAs($user)
            ->get('/users')
            ->assertViewIs('users.index')
            ->assertViewHas('users');
    }

    /**
     * resources/views/users/index
     * @test
     * @return void
     */
    public function authUserCanSeeUsersIndexPage(): void
    {
        $user = factory(User::class)->make();
        $this->actingAs($user)->get('/users')->assertOk();
    }

    /**
     * resources/views/users/index
     * @test
     * @return void
     */
    public function guestCanSeeUsersIndexPage(): void
    {
        $this->get('/users')->assertOk();
    }
}
