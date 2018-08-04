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
    public function viewSettingsGeneralHasACorrectPath(): void
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
    public function authUserCanSeeSettingsGeneralPage(): void
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)->get('/settings/general')->assertOk();
    }

    /**
     * resources/views/settings/general
     * @test
     * @return void
     */
    public function guestCantSeeSettingsGeneralPage(): void
    {
        $this->get('/settings/general')->assertRedirect('/login');
    }
}
