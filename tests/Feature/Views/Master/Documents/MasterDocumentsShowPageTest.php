<?php

namespace Tests\Feature\Views\Master\Documents;

use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MasterDocumentsShowPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_has_data(): void
    {
        $document = create(Document::class);

        $this->get("/documents/$document->id")
            ->assertViewIs('master.documents.show')
            ->assertViewHas('document', Document::find($document->id));
    }

    /** @test */
    public function user_can_see_the_page_if_document_is_ready(): void
    {
        $document = create(Document::class);

        $this->actingAs(make(User::class))
            ->get("/documents/$document->id")
            ->assertOk();
    }

    /** @test */
    public function user_cant_see_the_page_if_document_is_not_ready(): void
    {
        $document = create(Document::class, ['ready_' . lang() => 0]);

        $this->actingAs(make(User::class))
            ->get("/documents/$document->id")
            ->assertRedirect();
    }

    /** @test */
    public function master_can_see_the_page_if_document_is_not_ready(): void
    {
        $document = create(Document::class, ['ready_' . lang() => 0]);

        $this->actingAs(create_user('master'))
            ->get("/documents/$document->id")
            ->assertOk();
    }
}
