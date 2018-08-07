<?php

namespace Tests\Feature\Views\Settings;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SettingsGeneralPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * resources/views/settings/general
     * @test
     * @return void
     */
    public function view_settings_general_has_a_correct_path(): void
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get('/settings/general')
            ->assertViewIs('settings.general');
    }

    /**
     * resources/views/settings/general
     * @test
     * @return void
     */
    public function auth_user_can_see_settings_general_page(): void
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)->get('/settings/general')->assertOk();
    }

    /**
     * resources/views/settings/general
     * @test
     * @return void
     */
    public function guest_cant_see_settings_general_page(): void
    {
        $this->get('/settings/general')->assertRedirect('/login');
    }
}
