<?php

namespace Tests\Feature\Views\Users;

use Tests\TestCase;
use App\Models\User;

class UsersIndexPageTest extends TestCase
{
    /**
     * @test
     */
    public function view_has_data(): void
    {
        $this->actingAs(make(User::class))
            ->get('/users')
            ->assertViewIs('users.index')
            ->assertViewHas('users');
    }

    /**
     * @test
     */
    public function guest_can_see_the_page(): void
    {
        $this->get('/users')->assertOk();
    }
}
