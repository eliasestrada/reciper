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
    public function authUserCanSeeUsersIndexPage(): void
    {
        $this->actingAs(factory(User::class)->create())
            ->get('/users')
            ->assertOk()
            ->assertViewIs('users.index');
    }

    /**
     * resources/views/users/index
     * @test
     * @return void
     */
    public function guestCanSeeUsersIndexPage(): void
    {
        $this->get('/users')
            ->assertOk()
            ->assertViewIs('users.index');
    }
}
