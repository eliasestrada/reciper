<?php

namespace Tests\Feature\Auth\Users\Pages\CanSee;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserCanSeeNotificationsPagesTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test for notifications page. View: resources/views/notifications/index
	 * @return void
	 * @test
	 */
	public function userCanSeeNotificationsPage() : void
    {
		$user = User::find(factory(User::class)->create()->id);

		$this->actingAs($user)
			->get('/notifications')
			->assertSuccessful()
			->assertViewIs('notifications.index');
	}
}
