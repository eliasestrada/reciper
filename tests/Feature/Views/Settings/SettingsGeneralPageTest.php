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
    public function viewSettingsGeneralHasACorrectPath(): void
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get('/settings/general')
            ->assertViewIs('settings.general');
    }

    /**
     * Test for settigs general page
     * View: resources/views/settings/general
     * @return void
     * @test
     */
    public function authUserCanSeeSettingsGeneralPage(): void
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)->get('/settings/general')->assertOk();
    }

    /**
     * Test for settigs general page
     * View: resources/views/settings/general
     * @return void
     * @test
     */
    public function guestCantSeeSettingsGeneralPage(): void
    {
        $this->get('/settings/general')->assertRedirect('/login');
    }
}
