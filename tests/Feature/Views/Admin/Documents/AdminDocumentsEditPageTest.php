<?php

namespace Tests\Feature\Views\Admin\Documents;

use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminDocumentsEditPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * resources/views/admin/documents/edit
     * @test
     * @return void
     */
    public function viewAdminDocumentsEditHasData(): void
    {
        $document = factory(Document::class)->create();
        $admin = factory(User::class)->make(['admin' => 1]);

        $this->actingAs($admin)
            ->get("/admin/documents/$document->id/edit")
            ->assertOk()
            ->assertViewIs('admin.documents.edit')
            ->assertViewHas('document');
    }

    /**
     * resources/views/admin/documents/edit
     * @test
     * @return void
     */
    public function userCannotSeeAdminDocumentsEditPage(): void
    {
        $document = factory(Document::class)->create();

        $this->actingAs(factory(User::class)->make(['admin' => 0]))
            ->get("/admin/documents/$document->id/edit")
            ->assertRedirect('/login');
    }
}
