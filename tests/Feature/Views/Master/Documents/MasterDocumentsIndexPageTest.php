<?php

namespace Tests\Feature\Views\Master\Documents;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MasterDocumentsIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_is_correct(): void
    {
        $this->actingAs(create_user('master'))
            ->get("/master/documents")
            ->assertOk()
            ->assertViewIs('master.documents.index')
            ->assertViewHasAll(['ready_docs', 'unready_docs']);
    }

    /** @test */
    public function user_cant_see_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get('/master/documents')
            ->assertRedirect('/');
    }
}
