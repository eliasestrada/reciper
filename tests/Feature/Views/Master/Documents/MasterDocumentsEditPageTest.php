<?php

namespace Tests\Feature\Views\Master\Documents;

use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MasterDocumentsEditPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_edit_page_has_data(): void
    {
        $document = create(Document::class);
        $admin = create_user('master');

        $this->actingAs($admin)
            ->get("/master/documents/$document->id/edit")
            ->assertOk()
            ->assertViewIs('master.documents.edit')
            ->assertViewHas('document', Document::find($document->id));
    }

    /** @test */
    public function user_cannot_see_edit_page(): void
    {
        $document_id = create(Document::class)->id;

        $this->actingAs(make(User::class))
            ->get("/master/documents/$document_id/edit")
            ->assertRedirect('/');
    }
}
