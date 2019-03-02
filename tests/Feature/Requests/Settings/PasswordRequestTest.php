<?php

namespace Tests\Feature\Requests\Settings;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PasswordRequestTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var \App\Models\User $user
     */
    private $user;

    /**
     * @var int $pwd_max
     */
    private $pwd_max;

    /**
     * @var int $pwd_min
     */
    private $pwd_min;

    /**
     * @var \Illuminate\Foundation\Testing\TestResponse $request
     */
    private $request;

    /**
     * Setup the test environment
     * 
     * @author Cho
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->user = create_user('', ['password' => bcrypt('111111')]);
        $this->pwd_min = config('valid.settings.password.min');
        $this->pwd_max = config('valid.settings.password.max');

        $this->actingAs($this->user)->get('/settings/general');
        $this->request = $this->actingAs($this->user)->followingRedirects();
    }

    /**
     * @author Cho
     * @test
     */
    public function old_password_is_required(): void
    {
        $this->request->put(action('Settings\GeneralController@updatePassword'), [
            'old_password' => '',
            'password' => string_random(14),
        ])->assertSeeText(trans('settings.old_pwd_required'));
    }

    /**
     * @author Cho
     * @test
     */
    public function old_password_must_be_string(): void
    {
        $this->request->put(action('Settings\GeneralController@updatePassword'), [
            'old_password' => 111111,
            'password' => '111111',
            'password_confirmation' => '111111',
        ])->assertSeeText(trans('settings.old_pwd_string'));
    }

    /**
     * @author Cho
     * @test
     */
    public function password_must_be_string(): void
    {
        $this->request->put(action('Settings\GeneralController@updatePassword'), [
            'old_password' => '111111',
            'password' => 111111,
            'password_confirmation' => 111111,
        ])->assertSeeText(trans('settings.pwd_string'));
    }

    /**
     * @author Cho
     * @test
     */
    public function password_is_required(): void
    {
        $this->request->put(action('Settings\GeneralController@updatePassword'), [
            'old_password' => '111111',
            'password' => '',
            'password_confirmation' => '',
        ])->assertSeeText(trans('settings.pwd_required'));
    }

    /**
     * @author Cho
     * @test
     */
    public function password_must_be_not_short(): void
    {
        $this->request->put(action('Settings\GeneralController@updatePassword'), [
            'old_password' => $this->user->password,
            'password' => $new_pwd = string_random($this->pwd_min - 1),
            'password_confirmation' => $new_pwd,
        ])->assertSeeText(preg_replace('/:min/', $this->pwd_min, trans('settings.pwd_min')));
    }

    /**
     * @author Cho
     * @test
     */
    public function password_must_be_not_long(): void
    {
        $this->request->put(action('Settings\GeneralController@updatePassword'), [
            'old_password' => $this->user->password,
            'password' => $new_pwd = string_random($this->pwd_max + 1),
            'password_confirmation' => $new_pwd,
        ])->assertSeeText(preg_replace('/:max/', $this->pwd_max, trans('settings.pwd_max')));
    }

    /**
     * @author Cho
     * @test
     */
    public function password_must_be_confirmed(): void
    {
        $this->request->put(action('Settings\GeneralController@updatePassword'), [
            'old_password' => $this->user->password,
            'password' => string_random(10),
            'password_confirmation' => string_random(11),
        ])->assertSeeText(trans('settings.pwd_confirmed'));
    }
}
