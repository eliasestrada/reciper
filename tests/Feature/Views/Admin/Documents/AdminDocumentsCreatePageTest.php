<?php

namespace Tests\Feature\Views\Admin\Documents;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminDocumentsCreatePageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_admin_documents_create_has_a_correct_path(): void
    {
        $admin = create_user('admin');

        $this->actingAs($admin)
            ->get('/admin/documents/create')
            ->assertOk()
            ->assertViewIs('admin.documents.create');
    }

    /** @test */
    public function user_cant_see_admin_documents_create_page(): void
    {
        $user = make(User::class);

        $this->actingAs($user)
            ->get("/admin/documents/create")
            ->assertRedirect('/');
    }
}
