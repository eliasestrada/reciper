<?php

namespace Tests\Feature\Views\Settings;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SettingsPhotoPageTest extends TestCase
{
	use DatabaseTransactions;

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
			->assertOk()
			->assertViewIs('settings.photo');
	}
}
