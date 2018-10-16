<?php

namespace Tests\Feature\Requests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AuthLoginRequestTest extends TestCase
{
    use DatabaseTransactions;

    private $user;
    private $pwd_max;
    private $pwd_min;

    public function setUp()
    {
        parent::setUp();
        $this->user = create_user('', ['password' => bcrypt('111111')]);
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
