<?php

namespace Tests\Feature\Views\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RegisterPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * resources/views/auth/register
     * @test
     * @return void
     */
    public function user_cannot_see_register_page(): void
    {
        $this->actingAs(factory(User::class)->make())
            ->get('/register')
            ->assertRedirect('/dashboard')
            ->assertRedirect(action('DashboardController@index'));
    }

    /**
     * resources/views/auth/register
     * @test
     * @return void
     */
    public function guest_can_see_register_page(): void
    {
        $this->get('/register')
            ->assertOk()
            ->assertViewIs('auth.register');
    }
}
