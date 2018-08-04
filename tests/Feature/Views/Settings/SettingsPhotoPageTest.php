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
    public function viewSettingsPhotoHasACorrectPath(): void
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get('/settings/photo')
            ->assertViewIs('settings.photo');
    }

    /**
     * Test for settings photo page
     * View: resources/views/settings/photo
     * @return void
     * @test
     */
    public function authUserCanSeeSettingsPhotoPage(): void
    {
        $this->actingAs(factory(User::class)->create())
            ->get('/settings/photo')
            ->assertOk()
            ->assertViewIs('settings.photo');
    }

    /**
     * Test for settigs general page
     * View: resources/views/settings/photo
     * @return void
     * @test
     */
    public function guestCantSeeSettingsPhotoPage(): void
    {
        $this->get('/settings/photo')->assertRedirect('/login');
    }
}
