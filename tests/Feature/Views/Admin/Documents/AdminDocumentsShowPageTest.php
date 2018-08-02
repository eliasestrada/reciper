<?php

namespace Tests\Feature\Views\Admin\Documents;

use Tests\TestCase;
use App\Models\User;
use App\Models\Document;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminDocumentsPageTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test for documents show page. View: resources/views/admin/documents/show
	 * @return void
	 * @test
	 */
	public function userCantSeeAdminDocumentsShowPage() : void
    {
		$document = factory(Document::class)->create();

		$this->actingAs(factory(User::class)->make(['admin' => 0]))
			->get("/admin/documents/$document->id")
        	->assertRedirect('/login');
	}
}
