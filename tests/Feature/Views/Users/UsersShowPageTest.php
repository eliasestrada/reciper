<?php

namespace Tests\Feature\Views\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UsersShowPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * resources/view views/users/show
     * @test
     * @return void
     */
    public function authUserCanSeeUsersShowPage(): void
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get('/users/' . $user->id)
            ->assertOk()
            ->assertViewIs('users.show');
    }

    /**
     * resources/views/users/show
     * @test
     * @return void
     */
    public function guestCanSeeUsersShowPage(): void
    {
        $user = factory(User::class)->create();

        $this->get('/users/' . $user->id)
            ->assertOk()
            ->assertViewIs('users.show');
    }
}
