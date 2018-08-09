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
     * resources/views/admin/documents/show
     * @test
     * @return void
     */
    public function view_admin_documents_show_has_data(): void
    {
        $document = factory(Document::class)->create();

        $this->actingAs(factory(User::class)->create(['admin' => 1]))
            ->get("/admin/documents/$document->id")
            ->assertViewIs('admin.documents.show')
            ->assertViewHas('document', Document::find($document->id));
    }

    /**
     * resources/views/admin/documents/show
     * @test
     * @return void
     */
    public function user_cant_see_admin_documents_show_page(): void
    {
        $document = factory(Document::class)->create();

        $this->actingAs(factory(User::class)->make(['admin' => 0]))
            ->get("/admin/documents/$document->id")
            ->assertRedirect('/login');
    }

    /**
     * resources/views/admin/documents/show
     * @test
     * @return void
     */
    public function admin_can_see_admin_documents_show_page(): void
    {
        $document = factory(Document::class)->create();

        $this->actingAs(factory(User::class)->make(['admin' => 1]))
            ->get("/admin/documents/$document->id")
            ->assertOk();
    }
}
