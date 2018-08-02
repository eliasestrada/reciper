<?php

namespace Tests\Feature\Views\Admin\Checklist;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminChecklistIndexPageTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test for checklist page. View: resources/views/admin/checklist/index
	 * @return void
	 * @test
	 */
	public function userCantSeeAdminChecklistIndexPage() : void
    {
		$this->actingAs(factory(User::class)->make(['admin' => 0]))
			->get('/admin/checklist')
        	->assertRedirect('/login');
	}
}
