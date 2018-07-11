<?php

namespace Tests\Feature\Users\Pages\CantSee\AdminPages;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserCantSeeAdminFeedbackPagesTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test for feedback page. View: resources/views/admin/feedback/index
	 * @return void
	 * @test
	 */
	public function userCantSeeAdminFeedbackIndexPage() : void
    {
		$this->actingAs(factory(User::class)->make(['admin' => 0]))
			->get('/admin/feedback')
        	->assertRedirect('/login');
	}
}
