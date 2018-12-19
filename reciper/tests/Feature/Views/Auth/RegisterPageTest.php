<?php

namespace Tests\Feature\Views\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RegisterPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @author Cho
     * @test
     */
    public function auth_user_cant_see_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get('/register')
            ->assertRedirect();
    }

    /**
     * @author Cho
     * @test
     */
    public function guest_can_see_the_page(): void
    {
        $this->get('/register')
            ->assertOk()
            ->assertViewIs('auth.register');
    }

    /**
     * @author Cho
     * @test
     */
    public function new_user_can_register_with_correct_data(): void
    {
        $form_data = [
            'username' => str_random(5),
            'password' => '111111',
            'password_confirmation' => '111111',
        ];

        $this->post(route('register'), $form_data);
        $this->assertDatabaseHas('users', ['username' => $form_data['username']]);
    }
}
