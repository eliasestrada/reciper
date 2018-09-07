<?php

namespace Tests\Feature\Views\Admin\Documents;

use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminDocumentsIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_admin_documents_index_is_correct(): void
    {
        $admin = make(User::class, ['admin' => 1]);

        $this->actingAs($admin)
            ->get("/admin/documents")
            ->assertViewIs('admin.documents.index')
            ->assertViewHas('ready_docs', Document::query()->ready(1)->paginate(20)->onEachSide(1))
            ->assertViewHas('unready_docs', Document::query()->ready(0)->paginate(20)->onEachSide(1));
    }

    /** @test */
    public function user_cant_see_admin_documents_index_page(): void
    {
        $user = make(User::class, ['admin' => 0]);

        $this->actingAs($user)
            ->get('/admin/documents')
            ->assertRedirect('/');
    }

    /** @test */
    public function admin_can_see_admin_documents_index_page(): void
    {
        $admin = make(User::class, ['admin' => 1]);

        $this->actingAs($admin)
            ->get('/admin/documents')
            ->assertOk();
    }
}
