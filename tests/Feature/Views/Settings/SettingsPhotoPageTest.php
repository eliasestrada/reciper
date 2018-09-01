<?php

namespace Tests\Feature\Views\Settings;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SettingsPhotoPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * @return void
     */
    public function view_settings_photo_has_a_correct_path(): void
    {
        $this->actingAs(make(User::class))
            ->get('/settings/photo')
            ->assertViewIs('settings.photo');
    }

    /**
     * @test
     * @return void
     */
    public function auth_user_can_see_settings_photo_page(): void
    {
        $this->actingAs(make(User::class))
            ->get('/settings/photo')
            ->assertOk()
            ->assertViewIs('settings.photo');
    }

    /**
     * @test
     * @return void
     */
    public function guest_cant_see_settings_photo_page(): void
    {
        $this->get('/settings/photo')->assertRedirect('/login');
    }
}
