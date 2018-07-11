<?php

namespace Tests\Feature\Auth\Users\Pages\CantSee\AdminPages;

use Tests\TestCase;
use App\Models\User;
use App\Models\Document;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserCantSeeAdminDocumentPagesTest extends TestCase
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
