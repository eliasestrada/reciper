<?php

namespace Tests\Feature\Views\Settings;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SettingsPhotoPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_has_a_correct_path(): void
    {
        $this->actingAs(make(User::class))
            ->get('/settings/photo')
            ->assertViewIs('settings.photo');
    }

    /** @test */
    public function auth_user_can_see_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get('/settings/photo')
            ->assertOk()
            ->assertViewIs('settings.photo');
    }

    /** @test */
    public function guest_cant_see_the_page(): void
    {
        $this->get('/settings/photo')->assertRedirect('/login');
    }
}
