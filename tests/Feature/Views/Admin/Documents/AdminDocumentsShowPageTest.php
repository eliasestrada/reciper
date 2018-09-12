<?php

namespace Tests\Feature\Views\Admin\Documents;

use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminDocumentsPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_admin_documents_show_has_data(): void
    {
        $document = create(Document::class);

        $this->actingAs(create_user('admin'))
            ->get("/admin/documents/$document->id")
            ->assertViewIs('admin.documents.show')
            ->assertViewHas('document', Document::find($document->id));
    }

    /** @test */
    public function user_cant_see_admin_documents_show_page(): void
    {
        $document = create(Document::class);

        $this->actingAs(make(User::class))
            ->get("/admin/documents/$document->id")
            ->assertRedirect('/');
    }

    /** @test */
    public function admin_can_see_admin_documents_show_page(): void
    {
        $document = create(Document::class);

        $this->actingAs(create_user('admin'))
            ->get("/admin/documents/$document->id")
            ->assertOk();
    }
}
