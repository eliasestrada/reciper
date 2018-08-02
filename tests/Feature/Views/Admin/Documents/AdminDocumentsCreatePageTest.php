<?php

namespace Tests\Feature\Views\Admin\Documents;

use Tests\TestCase;
use App\Models\User;
use App\Models\Document;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminDocumentsCreatePageTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test for documents create page. View: resources/views/admin/documents/create
	 * @return void
	 * @test
	 */
	public function userCantSeeAdminDocumentsCreatePage() : void
    {
		$this->actingAs(factory(User::class)->make(['admin' => 0]))
			->get("/admin/documents/create")
        	->assertRedirect('/login');
	}
}
