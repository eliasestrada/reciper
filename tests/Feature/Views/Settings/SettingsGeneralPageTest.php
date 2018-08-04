<?php

namespace Tests\Feature\Views\Settings;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SettingsGeneralPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test for settigs general page. View: resources/views/settings/general
     * @return void
     * @test
     */
    public function authUserCanSeeSettingsGeneralPage(): void
    {
        $user = User::find(factory(User::class)->create()->id);

        $this->actingAs($user)
            ->get('/settings/general')
            ->assertOk()
            ->assertViewIs('settings.general');
    }
}
