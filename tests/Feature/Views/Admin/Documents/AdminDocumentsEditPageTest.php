<?php

namespace Tests\Feature\Views\Admin\Documents;

use Tests\TestCase;
use App\Models\User;
use App\Models\Document;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminDocumentsEditPageTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test for documents edit page. View: resources/views/admin/documents/edit
	 * @return void
	 * @test
	 */
	public function userCannotSeeAdminDocumentsEditPage() : void
    {
		$document = factory(Document::class)->create();

		$this->actingAs(factory(User::class)->make(['admin' => 0]))
			->get("/admin/documents/$document->id/edit")
        	->assertRedirect('/login');
	}
}
