<?php

namespace Tests\Feature\Views\Settings;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SettingsPhotoPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * resources/views/settings/photo
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
     * resources/views/settings/photo
     * @test
     * @return void
     */
    public function authUserCanSeeSettingsPhotoPage(): void
    {
        $this->actingAs(factory(User::class)->create())
            ->get('/settings/photo')
            ->assertOk()
            ->assertViewIs('settings.photo');
    }

    /**
     * resources/views/settings/photo
     * @test
     * @return void
     */
    public function guestCantSeeSettingsPhotoPage(): void
    {
        $this->get('/settings/photo')->assertRedirect('/login');
    }
}
