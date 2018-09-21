<?php

namespace Tests\Feature\Views\Settings;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SettingsGeneralPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_has_a_correct_path(): void
    {
        $this->actingAs(make(User::class))
            ->get('/settings/general')
            ->assertViewIs('settings.general');
    }

    /** @test */
    public function auth_user_can_see_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get('/settings/general')
            ->assertOk();
    }

    /** @test */
    public function guest_cant_see_the_page(): void
    {
        $this->get('/settings/general')->assertRedirect('/login');
    }

    /** @test */
    public function user_can_update_his_name(): void
    {
        $user = create_user();

        $this->actingAs($user)
            ->put(action('SettingsController@updateUserData'), ['name' => 'new name']);
        $this->assertEquals($user->name, 'new name');
    }

    /** @test */
    public function user_cant_update_his_name_to_empty(): void
    {
        $user = create_user('', ['name' => 'Mike']);

        $this->actingAs($user)->put(action('SettingsController@updateUserData'), ['name' => '']);
        $this->assertEquals($user->name, 'Mike');
    }

    /** @test */
    public function user_can_change_his_pwd_with_correct_pwd(): void
    {
        $user = create_user('', ['password' => bcrypt('test')]);

        $this->actingAs($user)
            ->put(action('SettingsController@updateUserPassword'), [
                'old_password' => 'test',
                'password' => 'new_password',
                'password_confirmation' => 'new_password',
            ]);

        $this->assertTrue(\Hash::check('new_password', $user->password));
    }

    /** @test */
    public function user_cant_change_his_pwd_with_incorrect_pwd(): void
    {
        $user = create(User::class, ['password' => bcrypt('test')]);

        $this->actingAs($user)
            ->put(action('SettingsController@updateUserPassword'), [
                'old_password' => 'other_test',
                'password' => 'new_password',
                'password_confirmation' => 'new_password',
            ]);

        $this->assertFalse(\Hash::check('new_password', $user->password));
    }

    /** @test */
    public function user_cant_change_his_pwd_to_empty_field(): void
    {
        $user = create(User::class, ['password' => bcrypt('testing')]);

        $this->actingAs($user)
            ->put(action('SettingsController@updateUserPassword'), [
                'old_password' => 'testing',
                'password' => '',
                'password_confirmation' => '',
            ]);

        $this->assertTrue(\Hash::check('testing', $user->password));
    }

    /** @test */
    public function user_cant_change_his_pwd_with_incorrect_confirm_pwd(): void
    {
        $user = create(User::class, ['password' => bcrypt('test')]);

        $this->actingAs($user)
            ->put(action('SettingsController@updateUserPassword'), [
                'old_password' => 'test',
                'password' => 'new_password',
                'password_confirmation' => 'other_new_password',
            ]);

        $this->assertFalse(\Hash::check('new_password', $user->password));
    }
}
