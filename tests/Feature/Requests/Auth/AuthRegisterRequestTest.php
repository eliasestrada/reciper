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
    private $data = [];

    public function setUp()
    {
        parent::setUp();
        $this->name_min = config('valid.settings.general.name.min');
        $this->name_max = config('valid.settings.general.name.max');
        $this->pwd_min = config('valid.settings.password.min');
        $this->pwd_max = config('valid.settings.password.max');
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
}
