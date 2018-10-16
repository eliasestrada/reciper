<?php

namespace Tests\Feature\Views\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RegisterPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function auth_user_cannot_see_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get('/register')
            ->assertRedirect('/dashboard')
            ->assertRedirect(action('DashboardController@index'));
    }

    /** @test */
    public function guest_can_see_the_page(): void
    {
        $this->get('/register')
            ->assertOk()
            ->assertViewIs('auth.register');
    }

    /** @test */
    public function new_user_can_register(): void
    {
        $faker = \Faker\Factory::create();
        $form_data = [
            'username' => $faker->username,
            'password' => '111111',
            'password_confirmation' => '111111',
        ];

        $this->post(route('register'), $form_data)->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', ['email' => $form_data['email']]);
    }
}
