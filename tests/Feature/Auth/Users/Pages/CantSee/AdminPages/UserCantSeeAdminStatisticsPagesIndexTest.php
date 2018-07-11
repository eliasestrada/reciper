<?php

namespace Tests\Feature\Auth\Users\Pages\CantSee\AdminPages;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserCantSeeAdminStatisticsPagesIndexTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test for statistic page. View: resources/views/admin/statistics/index
	 * @return void
	 * @test
	 */
	public function userCantSeeAdminStatisticsIndexPage() : void
    {
		$this->actingAs(factory(User::class)->make(['admin' => 0]))
			->get('/admin/statistics')
        	->assertRedirect('/login');
	}
}
