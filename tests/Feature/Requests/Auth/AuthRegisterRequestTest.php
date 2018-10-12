<?php

namespace Tests\Feature\Requests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AuthRegisterRequestTest extends TestCase
{
    use DatabaseTransactions;

    private $name_min;
    private $name_max;
    private $pwd_min;
    private $pwd_max;
    private $email_max;
    private $data = [];

    public function setUp()
    {
        parent::setUp();
        $this->name_min = config('valid.settings.general.name.min');
        $this->name_max = config('valid.settings.general.name.max');
        $this->pwd_min = config('valid.settings.password.min');
        $this->pwd_max = config('valid.settings.password.max');
        $this->email_max = config('valid.settings.email.max');
        $this->data = [
            'name' => str_random(10),
            'email' => rand() . '@mail.ru',
            'password' => '111111',
            'password_confirmation' => '111111',
        ];
    }

    /** @test */
    public function name_is_required(): void
    {
        $this->data['name'] = '';
        $this->followingRedirects()
            ->post(route('register'), $this->data)
            ->assertSeeText(trans('auth.name_required'));
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
    public function name_must_be_not_short(): void
    {
        $this->data['name'] = str_random($this->name_min - 1);

        $this->followingRedirects()
            ->post(route('register'), $this->data)
            ->assertSeeText(preg_replace('/:min/', $this->name_min, trans('auth.name_min')));
    }

    /** @test */
    public function name_must_be_not_long(): void
    {
        $this->data['name'] = str_random($this->name_max + 1);

        $this->followingRedirects()
            ->post(route('register'), $this->data)
            ->assertSeeText(preg_replace('/:max/', $this->name_max, trans('auth.name_max')));
    }

    /** @test */
    public function name_must_be_string(): void
    {
        $this->data['name'] = 12553;

        $this->followingRedirects()
            ->post(route('register'), $this->data)
            ->assertSeeText(trans('auth.name_string'));
    }

    /** @test */
    public function email_must_be_like_a_proper_email_address(): void
    {
        $emails = ['tarleva@mail,com', 'chernov@gmail', 'voronov.com', '1990senya@q'];

        foreach ($emails as $email) {
            $this->data['email'] = $email;
            $this->followingRedirects()
                ->post(route('register'), $this->data)
                ->assertSeeText(trans('auth.email_email'));
        }
    }

    /** @test */
    public function email_must_be_not_long(): void
    {
        $this->data['email'] = str_random($this->email_max + 1);

        $this->followingRedirects()
            ->post(route('register'), $this->data)
            ->assertSeeText(preg_replace('/:max/', $this->email_max, trans('auth.email_max')));
    }

    /** @test */
    public function email_must_be_unique(): void
    {
        $this->data['email'] = create_user()->email;

        $this->followingRedirects()
            ->post(route('register'), $this->data)
            ->assertSeeText(trans('auth.email_unique'));
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
        $this->data['password'] = str_random($this->pwd_min - 1);

        $this->followingRedirects()
            ->post(route('register'), $this->data)
            ->assertSeeText(preg_replace('/:min/', $this->pwd_min, trans('auth.password_min')));
    }

    /** @test */
    public function password_must_be_not_long(): void
    {
        $this->data['password'] = str_random($this->pwd_max + 1);

        $this->followingRedirects()
            ->post(route('register'), $this->data)
            ->assertSeeText(preg_replace('/:max/', $this->pwd_max, trans('auth.password_max')));
    }

    /** @test */
    public function password_must_be_confirmed(): void
    {
        $this->data['password_confirmation'] = str_random(10);

        $this->followingRedirects()
            ->post(route('register'), $this->data)
            ->assertSeeText(trans('auth.password_confirmed'));
    }
}
