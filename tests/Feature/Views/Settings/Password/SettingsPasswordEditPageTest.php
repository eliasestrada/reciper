<?php

namespace Tests\Feature\Views\Settings\General;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SettingsPasswordEditPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_has_a_correct_path(): void
    {
        $this->actingAs(make(User::class))
            ->get('/settings/password/edit')
            ->assertViewIs('settings.password.edit');
    }

    /** @test */
    public function auth_user_can_see_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get('/settings/password/edit')
            ->assertOk();
    }

    /** @test */
    public function guest_cant_see_the_page(): void
    {
        $this->get('/settings/password/edit')->assertRedirect('/login');
    }

    /** @test */
    public function user_can_change_his_pwd_with_correct_pwd(): void
    {
        $user = create_user('', ['password' => bcrypt('test')]);

        $this->actingAs($user)
            ->put(action('Settings\PasswordController@update'), [
                'old_password' => 'test',
                'password' => 'new_password',
                'password_confirmation' => 'new_password',
            ]);

        $this->assertTrue(\Hash::check('new_password', $user->password));
    }

    /** @test */
    public function user_cant_change_his_pwd_with_incorrect_pwd(): void
    {
        $user = create_user('', ['password' => bcrypt('test')]);

        $this->actingAs($user)
            ->put(action('Settings\GeneralController@update'), [
                'old_password' => 'other_test',
                'password' => 'new_password',
                'password_confirmation' => 'new_password',
            ]);

        $this->assertFalse(\Hash::check('new_password', $user->password));
    }

    /** @test */
    public function user_cant_change_his_pwd_to_empty_field(): void
    {
        $user = create_user('', ['password' => bcrypt('testing')]);

        $this->actingAs($user)
            ->put(action('Settings\GeneralController@update'), [
                'old_password' => 'testing',
                'password' => '',
                'password_confirmation' => '',
            ]);

        $this->assertTrue(\Hash::check('testing', $user->password));
    }

    /** @test */
    public function user_cant_change_his_pwd_with_incorrect_confirm_pwd(): void
    {
        $user = create_user('', ['password' => bcrypt('test')]);

        $this->actingAs($user)
            ->put(action('Settings\GeneralController@update'), [
                'old_password' => 'test',
                'password' => 'new_password',
                'password_confirmation' => 'other_new_password',
            ]);

        $this->assertFalse(\Hash::check('new_password', $user->password));
    }
}
