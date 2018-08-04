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
    public function viewDocumentsCreateHasACorrectPath(): void
    {
        $admin = factory(User::class)->make(['admin' => 1]);

        $this->actingAs($admin)
            ->get('/admin/documents/create')
            ->assertOk()
            ->assertViewIs('admin.documents.create');
    }

    /**
     * Test for documents create page. View: resources/views/admin/documents/create
     * @return void
     * @test
     */
    public function userCantSeeAdminDocumentsCreatePage(): void
    {
        $user = factory(User::class)->make(['admin' => 0]);

        $this->actingAs($user)
            ->get("/admin/documents/create")
            ->assertRedirect('/login');
    }
}
