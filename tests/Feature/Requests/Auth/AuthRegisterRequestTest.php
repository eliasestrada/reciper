<?php

namespace Tests\Feature\Requests;

use Tests\TestCase;

class AuthRegisterRequestTest extends TestCase
{
    private $data = [];

    public function setUp()
    {
        parent::setUp();
        $this->data = [
            'username' => str_random(10),
            'password' => '111111',
            'password_confirmation' => '111111',
        ];
    }

    /** @test */
    public function password_is_required(): void
    {
        $this->data['password'] = '';
        $this->followingRedirects()
            ->post(route('register'), $this->data)
            ->assertSeeText(trans('auth.password_required'));
    }

    /** @test */
    public function password_must_be_string(): void
    {
        $this->data['password'] = 121323553;

        $this->followingRedirects()
            ->post(route('register'), $this->data)
            ->assertSeeText(trans('auth.password_string'));
    }

    /** @test */
    public function password_must_be_not_short(): void
    {
        $pwd_min = config('valid.settings.password.min');
        $this->data['password'] = str_random($pwd_min - 1);

        $this->followingRedirects()
            ->post(route('register'), $this->data)
            ->assertSeeText(preg_replace('/:min/', $pwd_min, trans('auth.password_min')));
    }

    /** @test */
    public function password_must_be_not_long(): void
    {
        $pwd_max = config('valid.settings.password.max');
        $this->data['password'] = str_random($pwd_max + 1);

        $this->followingRedirects()
            ->post(route('register'), $this->data)
            ->assertSeeText(preg_replace('/:max/', $pwd_max, trans('auth.password_max')));
    }

    /** @test */
    public function password_must_be_confirmed(): void
    {
        $this->data['password_confirmation'] = str_random(10);

        $this->followingRedirects()
            ->post(route('register'), $this->data)
            ->assertSeeText(trans('auth.password_confirmed'));
    }

    /** @test */
    public function username_must_be_not_short(): void
    {
        $username_min = config('valid.settings.username.min');
        $this->data['username'] = str_random($username_min - 1);

        $this->followingRedirects()
            ->post(route('register'), $this->data)
            ->assertSeeText(preg_replace('/:min/', $username_min, trans('auth.username_min')));
    }

    /** @test */
    public function username_must_be_not_long(): void
    {
        $username_max = config('valid.settings.username.max');
        $this->data['username'] = str_random($username_max + 1);

        $this->followingRedirects()
            ->post(route('register'), $this->data)
            ->assertSeeText(preg_replace('/:max/', $username_max, trans('auth.username_max')));
    }

    /** @test */
    public function username_must_be_string(): void
    {
        $this->data['username'] = 135324235;

        $this->followingRedirects()
            ->post(route('register'), $this->data)
            ->assertSeeText(trans('auth.username_string'));
    }

    /** @test */
    public function username_must_be_unique(): void
    {
        $this->data['username'] = 'master';

        $this->followingRedirects()
            ->post(route('register'), $this->data)
            ->assertSeeText(trans('auth.username_unique'));
    }

    /** @test */
    public function username_must_be_alpha_dash(): void
    {
        $usernames = ['sffsf sdf', 'на русском'];

        foreach ($usernames as $username) {
            $this->data['username'] = $username;
            $this->followingRedirects()
                ->post(route('register'), $this->data)
                ->assertSeeText(trans('auth.username_alpha_dash'));
        }
    }

    /** @test */
    public function username_must_be_latin_with_dash_or_underscore(): void
    {
        $usernames = ['stiven-', 'на скрипке', 'Андрей', '_owen', '_jonce_steven'];

        foreach ($usernames as $username) {
            $this->data['username'] = $username;
            $this->followingRedirects()
                ->post(route('register'), $this->data)
                ->assertSeeText(trans('auth.username_regex'));
        }
    }
}
