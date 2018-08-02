<?php

namespace Tests\Feature\Views\Notifications;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NotificationsIndexPageTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test for notifications page. View: resources/views/notifications/index
	 * @return void
	 * @test
	 */
	public function userCanSeeNotificationsIndexPage() : void
    {
		$user = User::find(factory(User::class)->create()->id);

		$this->actingAs($user)
			->get('/notifications')
			->assertOk()
			->assertViewIs('notifications.index');
	}
}
