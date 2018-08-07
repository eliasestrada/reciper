<?php

namespace Feature\Views\Auth\Passwords;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PasswordsEmailTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * resources/views/auth/passwords/email
     * @test
     * @return void
     */
    public function guest_can_see_password_email_page(): void
    {
        $this->get('/password/reset')
            ->assertOk()
            ->assertViewIs('auth.passwords.email');
    }

    /**
     * resources/views/auth/passwords/email
     * @test
     * @return void
     */
    public function auth_user_cant_see_password_email_page(): void
    {
        $this->actingAs(factory(User::class)->create())
            ->get('/password/reset')
            ->assertRedirect('/dashboard');
    }
}
