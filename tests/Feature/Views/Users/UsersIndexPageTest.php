<?php

namespace Tests\Feature\Views\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UsersIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * @return void
     */
    public function view_users_index_has_data(): void
    {
        $this->actingAs(make(User::class))
            ->get('/users')
            ->assertViewIs('users.index')
            ->assertViewHas('users', User::paginate(50));
    }

    /**
     * @test
     * @return void
     */
    public function auth_user_can_see_users_index_page(): void
    {
        $this->actingAs(make(User::class))
            ->get('/users')
            ->assertOk();
    }

    /**
     * @test
     * @return void
     */
    public function guest_can_see_users_index_page(): void
    {
        $this->get('/users')->assertOk();
    }
}
