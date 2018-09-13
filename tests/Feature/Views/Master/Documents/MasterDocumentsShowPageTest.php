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
    public function view_show_page_has_data(): void
    {
        $document = create(Document::class);

        $this->actingAs(create_user('master'))
            ->get("/master/documents/$document->id")
            ->assertViewIs('master.documents.show')
            ->assertViewHas('document', Document::find($document->id));
    }

    /** @test */
    public function user_cant_see_show_page(): void
    {
        $document = create(Document::class);

        $this->actingAs(make(User::class))
            ->get("/master/documents/$document->id")
            ->assertRedirect('/');
    }

    /** @test */
    public function master_can_see_show_page(): void
    {
        $document = create(Document::class);

        $this->actingAs(create_user('master'))
            ->get("/master/documents/$document->id")
            ->assertOk();
    }
}
