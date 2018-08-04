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
    public function userCannotSeeRegisterPage(): void
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
    public function guestCanSeeRegisterPage(): void
    {
        $this->get('/register')
            ->assertOk()
            ->assertViewIs('auth.register');
    }
}
