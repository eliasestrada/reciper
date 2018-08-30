<?php

namespace Tests\Feature\Views\Settings;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SettingsGeneralPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * @return void
     */
    public function view_settings_general_has_a_correct_path(): void
    {
        $this->actingAs(create(User::class))
            ->get('/settings/general')
            ->assertViewIs('settings.general');
    }

    /**
     * @test
     * @return void
     */
    public function auth_user_can_see_settings_general_page(): void
    {
        $this->actingAs(create(User::class))
            ->get('/settings/general')
            ->assertOk();
    }

    /**
     * @test
     * @return void
     */
    public function guest_cant_see_settings_general_page(): void
    {
        $this->get('/settings/general')->assertRedirect('/login');
    }

    /**
     * @test
     * @return void
     */
    public function user_can_update_his_general_data(): void
    {
        $user = create(User::class, ['name' => 'Andr']);

        $this->actingAs($user)->get('/settings/general');

        $this->actingAs($user)
            ->put(action('SettingsController@updateUserData'), [
                'name' => 'Andrej',
            ])->assertRedirect('/settings/general');

        $this->assertEquals($user->name, 'Andrej');
    }

    /**
     * @test
     * @return void
     */
    public function user_can_change_his_pwd_with_correct_pwd(): void
    {
        $user = create(User::class, ['password' => bcrypt('test')]);

        $this->actingAs($user)->get('/settings/general');

        $this->actingAs($user)
            ->put(action('SettingsController@updateUserPassword'), [
                'old_password' => 'test',
                'password' => 'new_password',
                'password_confirmation' => 'new_password',
            ])->assertRedirect('/settings/general');

        $this->assertTrue(\Hash::check('new_password', $user->password));
    }

    /**
     * @test
     * @return void
     */
    public function user_cant_change_his_pwd_with_incorrect_pwd(): void
    {
        $user = create(User::class, ['password' => bcrypt('test')]);

        $this->actingAs($user)->get('/settings/general');

        $this->actingAs($user)
            ->put(action('SettingsController@updateUserPassword'), [
                'old_password' => 'other_test',
                'password' => 'new_password',
                'password_confirmation' => 'new_password',
            ])->assertRedirect('/settings/general');

        $this->assertFalse(\Hash::check('new_password', $user->password));
    }

    /**
     * @test
     * @return void
     */
    public function user_cant_change_his_pwd_with_incorrect_confirm_pwd(): void
    {
        $user = create(User::class, ['password' => bcrypt('test')]);

        $this->actingAs($user)->get('/settings/general');

        $this->actingAs($user)
            ->put(action('SettingsController@updateUserPassword'), [
                'old_password' => 'test',
                'password' => 'new_password',
                'password_confirmation' => 'other_new_password',
            ])
            ->assertRedirect('/settings/general');

        $this->assertFalse(\Hash::check('new_password', $user->password));
    }
}
