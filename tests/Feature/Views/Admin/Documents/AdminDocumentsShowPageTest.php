<?php

namespace Tests\Feature\Views\Admin\Documents;

use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminDocumentsPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * @return void
     */
    public function viewAdminDocumentsShowHasData(): void
    {
        $document = factory(Document::class)->create();

        $this->actingAs(factory(User::class)->create(['admin' => 1]))
            ->get("/admin/documents/$document->id")
            ->assertViewIs('admin.documents.show')
            ->assertViewHas('document');
    }

    /**
     * Test for documents show page. View: resources/views/admin/documents/show
     * @return void
     * @test
     */
    public function userCantSeeAdminDocumentsShowPage(): void
    {
        $document = factory(Document::class)->create();

        $this->actingAs(factory(User::class)->make(['admin' => 0]))
            ->get("/admin/documents/$document->id")
            ->assertRedirect('/login');
    }

    /**
     * Test for documents show page. View: resources/views/admin/documents/show
     * @return void
     * @test
     */
    public function adminCanSeeAdminDocumentsShowPage(): void
    {
        $document = factory(Document::class)->create();

        $this->actingAs(factory(User::class)->make(['admin' => 1]))
            ->get("/admin/documents/$document->id")
            ->assertOk();
    }
}
