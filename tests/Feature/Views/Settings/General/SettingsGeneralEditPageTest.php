<?php

namespace Tests\Feature\Views\Settings\General;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SettingsGeneralEditPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_has_a_correct_path(): void
    {
        $this->actingAs(make(User::class))
            ->get('/settings/general')
            ->assertViewIs('settings.general.index');
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

        $this->actingAs($user)->put(action('Settings\GeneralController@updateGeneral'), [
            'name' => 'new name',
        ]);
        $this->assertEquals('new name', $user->name);
    }

    /** @test */
    public function user_cant_update_his_name_to_short_one(): void
    {
        $name = str_random(10);
        $user = create_user('', compact('name'));

        $this->actingAs($user)->put(action('Settings\GeneralController@updateGeneral'), ['name' => 'ja']);
        $this->assertEquals($name, $user->name);
    }

    /** @test */
    public function user_can_change_about_me_information(): void
    {
        $user = create_user();
        $name = str_random(10);
        $status = str_random(30);

        $this->actingAs($user)->put(action('Settings\GeneralController@updateGeneral'), compact('name', 'status'));
        $this->assertEquals($status, $user->status);
    }

    /** @test */
    public function user_can_change_his_pwd_with_correct_pwd(): void
    {
        $user = create_user('', ['password' => bcrypt('test')]);

        $this->actingAs($user)
            ->put(action('Settings\GeneralController@updatePassword'), [
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
            ->put(action('Settings\GeneralController@updatePassword'), [
                'old_password' => 'other_test',
                'password' => 'new_password',
                'password_confirmation' => 'new_password',
            ]);

        $this->assertFalse(\Hash::check('new_password', $user->password));
    }
}
