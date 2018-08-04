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
    public function guestCanSeePasswordEmailPage(): void
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
    public function authUserCantSeePasswordEmailPage(): void
    {
        $this->actingAs(factory(User::class)->create())
            ->get('/password/reset')
            ->assertRedirect('/dashboard');
    }
}
