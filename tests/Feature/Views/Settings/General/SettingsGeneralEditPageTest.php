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
        $this->assertEquals($user->name, 'new name');
    }

    /** @test */
    public function user_cant_update_his_name_to_empty(): void
    {
        $user = create_user('', ['name' => 'Mike']);

        $this->actingAs($user)->put(action('Settings\SettingsGeneralController@update'), ['name' => '']);
        $this->assertEquals($user->name, 'Mike');
    }

    /** @test */
    // public function user_can_change_about_me_section(): void
    // {
    //     $user = create_user();
    //     $about_me = 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Omnis, eum.';

    //     $this->actingAs($user)->put(action('Settings\SettingsGeneralController@updateAboutMe'), compact('about_me'));
    //     $this->assertEquals($user->about_me, $about_me);
    // }
}
