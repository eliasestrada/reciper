<?php

namespace Tests\Feature\Requests\Auth;

use Tests\TestCase;
use App\Models\User;

class AuthLoginRequestTest extends TestCase
{
    /**
     * @var \App\Models\User
     */
    private $user;

    /**
     * @var int
     */
    private $pwd_max;

    /**
     * @var int
     */
    private $pwd_min;

    /**
     * Setup the test environment
     * 
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->user = make(User::class, ['id' => 1, 'password' => bcrypt('111111')]);
        $this->pwd_min = config('valid.settings.password.min');
        $this->pwd_max = config('valid.settings.password.max');

        $this->get(route('login'));
    }

    /**
     * @test
     */
    public function username_is_required(): void
    {
        $this->followingRedirects()
            ->post(route('login'), ['password' => '111111'])
            ->assertSeeText(trans('auth.username_required'));
    }

    /**
     * @test
     */
    public function password_is_required(): void
    {
        $this->followingRedirects()
            ->post(route('login'), ['email' => $this->user->email])
            ->assertSeeText(trans('auth.password_required'));
    }

    /**
     * @test
     */
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
