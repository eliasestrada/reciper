<?php

namespace Tests\Feature\Auth\Users\Pages\CanSee;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MasterCanSeeLogPagesTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test for logs page. View: resources/vendor/log-viewer/custom-theme/logs
	 * @return void
	 * @test
	 */
	public function masterCanSeeLogsPage() : void
    {
		$master = User::find(factory(User::class)->create(['master' => 1])->id);

		$this->actingAs($master)
			->get('/log-viewer/logs')
			->assertSeeText(trans('logs.logs'))
			->assertDontSeeText(trans('logs.page_is_not_avail'));
	}

	/**
	 * Test for log page. View: resources/vendor/log-viewer/custom-theme/show
	 * @return void
	 * @test
	 */
	public function masterCanSeeLogsShowsPage() : void
    {
		$master = User::find(factory(User::class)->create(['master' => 1])->id);
		info('test');
		$file_name = date('Y-m-d');

		$this->actingAs($master)
			->get("/log-viewer/logs/$file_name/info")
			->assertSeeText($file_name);
	}
}
