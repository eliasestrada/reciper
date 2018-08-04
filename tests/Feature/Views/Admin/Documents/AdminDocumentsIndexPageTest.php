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
     * @test
     * @return void
     */
    public function viewAdminDocumentsIndexIsCorrect(): void
    {
        $admin = factory(User::class)->make(['admin' => 1]);

        $this->actingAs($admin)
            ->get("/admin/documents")
            ->assertViewIs('admin.documents.index')
            ->assertViewHas('document');
    }

    /**
     * Test for documents page. View: resources/views/admin/documents/index
     * @return void
     * @test
     */
    public function userCantSeeAdminDocumentsIndexPage(): void
    {
        $user = factory(User::class)->make(['admin' => 0]);

        $this->actingAs($user)
            ->get('/admin/documents')
            ->assertRedirect('/login');
    }

    /**
     * Test for documents page. View: resources/views/admin/documents/index
     * @return void
     * @test
     */
    public function adminCanSeeAdminDocumentsIndexPage(): void
    {
        $admin = factory(User::class)->make(['admin' => 1]);

        $this->actingAs($admin)
            ->get('/admin/documents')
            ->assertOk();
    }
}
