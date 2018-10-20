<?php

namespace Tests\Feature\Requests;

use App\Models\User;
use Tests\TestCase;

class AuthLoginRequestTest extends TestCase
{
    private $user;
    private $pwd_max;
    private $pwd_min;

    public function setUp()
    {
        parent::setUp();
        $this->user = make(User::class, ['id' => 1, 'password' => bcrypt('111111')]);
        $this->pwd_min = config('valid.settings.password.min');
        $this->pwd_max = config('valid.settings.password.max');
    }

    /** @test */
    public function username_is_required(): void
    {
        $this->followingRedirects()
            ->post(route('login'), ['password' => '111111'])
            ->assertSeeText(trans('auth.username_required'));
    }

    /** @test */
    public function password_is_required(): void
    {
        $this->followingRedirects()
            ->post(route('login'), ['email' => $this->user->email])
            ->assertSeeText(trans('auth.password_required'));
    }

    /** @test */
    public function password_must_be_string(): void
    {
        $this->followingRedirects()
            ->post(route('login'), [
                'email' => $this->user->email,
                'password' => 111111,
            ])
            ->assertSeeText(trans('auth.password_string'));
    }
}
