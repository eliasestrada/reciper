<?php

namespace Tests\Feature\Auth\Users\Pages\CanSee;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserCanSeeSettingsPagesTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test for settigs general page. View: resources/views/settings/general
	 * @return void
	 * @test
	 */
	public function authUserCanSeeSettingsGeneralPage() : void
    {
		$user = User::find(factory(User::class)->create()->id);

		$this->actingAs($user)
			->get('/settings/general')
			->assertSuccessful()
			->assertViewIs('settings.general');
	}

	/**
	 * Test for settings photo page. View: resources/views/settings/photo
	 * @return void
	 * @test
	 */
	public function authUserCanSeeSettingsPhotoPage() : void
    {
		$user = User::find(factory(User::class)->create()->id);

		$this->actingAs($user)
			->get('/settings/photo')
			->assertSuccessful()
			->assertViewIs('settings.photo');
	}
}
