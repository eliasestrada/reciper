<?php

namespace Tests\Feature\Views\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function auth_user_cant_see_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get('/register')
            ->assertRedirect();
    }

    /**
     * @test
     */
    public function guest_can_see_the_page(): void
    {
        $this->get('/register')
            ->assertOk()
            ->assertViewIs('auth.register');
    }

    /**
     * @test
     */
    public function new_user_can_register_with_correct_data(): void
    {
        $password = string_random(config('valid.settings.password.min'));
        $form_data = [
            'username' => string_random(5),
            'password' => $password,
            'password_confirmation' => $password,
        ];

        $this->post(route('register'), $form_data);
        $this->assertDatabaseHas('users', ['username' => $form_data['username']]);
    }
}
