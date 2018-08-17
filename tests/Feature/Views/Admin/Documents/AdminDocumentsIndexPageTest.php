<?php

namespace Tests\Feature\Views\Admin\Documents;

use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminDocumentsIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * resources/views/admin/documents/index
     * @test
     * @return void
     */
    public function view_admin_documents_index_is_correct(): void
    {
        $admin = factory(User::class)->make(['admin' => 1]);

        $this->actingAs($admin)
            ->get("/admin/documents")
            ->assertViewIs('admin.documents.index')
            ->assertViewHas('documents', Document::get());
    }

    /**
     * resources/views/admin/documents/index
     * @test
     * @return void
     */
    public function user_cant_see_admin_documents_index_page(): void
    {
        $user = factory(User::class)->make(['admin' => 0]);

        $this->actingAs($user)
            ->get('/admin/documents')
            ->assertRedirect('/');
    }

    /**
     * resources/views/admin/documents/index
     * @test
     * @return void
     */
    public function admin_can_see_admin_documents_index_page(): void
    {
        $admin = factory(User::class)->make(['admin' => 1]);

        $this->actingAs($admin)
            ->get('/admin/documents')
            ->assertOk();
    }
}
