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
            ->get('/settings/general/edit')
            ->assertViewIs('settings.general.edit');
    }

    /** @test */
    public function auth_user_can_see_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get('/settings/general/edit')
            ->assertOk();
    }

    /** @test */
    public function guest_cant_see_the_page(): void
    {
        $this->get('/settings/general/edit')->assertRedirect('/login');
    }

    /** @test */
    public function user_can_update_his_name(): void
    {
        $user = create_user();

        $this->actingAs($user)
            ->put(action('Settings\SettingsGeneralController@update'), ['name' => 'new name']);
        $this->assertEquals('new_name', $user->name);
    }

    /** @test */
    public function user_cant_update_his_name_to_short_one(): void
    {
        $name = str_random(10);
        $user = create_user('', compact('name'));

        $this->actingAs($user)->put(action('Settings\SettingsGeneralController@update'), ['name' => 'ja']);
        $this->assertEquals($name, $user->name);
    }

    /** @test */
    public function user_can_change_about_me_information(): void
    {
        $user = create_user();
        $name = str_random(10);
        $about_me = str_random(30);

        $this->actingAs($user)->put(action('Settings\SettingsGeneralController@update'), compact('name', 'about_me'));
        $this->assertEquals($about_me, $user->about_me);
    }
}
