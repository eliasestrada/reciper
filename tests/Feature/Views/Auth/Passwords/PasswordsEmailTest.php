<?php

namespace Feature\Views\Auth\Passwords;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PasswordsEmailTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function guest_can_see_the_page(): void
    {
        $this->get('/password/reset')
            ->assertOk()
            ->assertViewIs('auth.passwords.email');
    }

    /**
     * @test
     */
    public function auth_user_cant_see_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get('/password/reset')
            ->assertRedirect('/dashboard');
    }
}
