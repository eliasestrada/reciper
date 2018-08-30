<?php

namespace Tests\Feature\Views\Admin\Documents;

use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminDocumentsCreatePageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * @return void
     */
    public function view_admin_documents_create_has_a_correct_path(): void
    {
        $admin = make(User::class, ['admin' => 1]);

        $this->actingAs($admin)
            ->get('/admin/documents/create')
            ->assertOk()
            ->assertViewIs('admin.documents.create');
    }

    /**
     * @test
     * @return void
     */
    public function user_cant_see_admin_documents_create_page(): void
    {
        $user = make(User::class, ['admin' => 0]);

        $this->actingAs($user)
            ->get("/admin/documents/create")
            ->assertRedirect('/');
    }
}
