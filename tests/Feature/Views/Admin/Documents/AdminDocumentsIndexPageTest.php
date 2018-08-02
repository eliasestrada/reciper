<?php

namespace Tests\Feature\Views\Admin\Documents;

use Tests\TestCase;
use App\Models\User;
use App\Models\Document;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminDocumentsIndexPageTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test for documents page. View: resources/views/admin/documents/index
	 * @return void
	 * @test
	 */
	public function userCantSeeAdminDocumentsIndexPage() : void
    {
		$this->actingAs(factory(User::class)->make(['admin' => 0]))
			->get('/admin/documents')
        	->assertRedirect('/login');
	}
}
