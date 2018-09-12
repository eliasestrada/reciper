<?php

namespace Tests\Feature\Views\Admin\Documents;

use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminDocumentsEditPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_admin_documents_edit_has_data(): void
    {
        $document = create(Document::class);
        $admin = create_user('admin');

        $this->actingAs($admin)
            ->get("/admin/documents/$document->id/edit")
            ->assertOk()
            ->assertViewIs('admin.documents.edit')
            ->assertViewHas('document', Document::find($document->id));
    }

    /** @test */
    public function user_cannot_see_admin_documents_edit_page(): void
    {
        $document_id = create(Document::class)->id;

        $this->actingAs(make(User::class))
            ->get("/admin/documents/$document_id/edit")
            ->assertRedirect('/');
    }
}
