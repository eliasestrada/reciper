<?php

namespace Tests\Feature\Views\Master\Documents;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MasterDocumentsIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function master_can_see_the_page(): void
    {
        $this->actingAs(create_user('master'))
            ->get("/master/documents")
            ->assertOk()
            ->assertViewIs('master.documents.index');
    }

    /** @test */
    public function user_cant_see_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get('/master/documents')
            ->assertRedirect();
    }
}
