<?php

namespace Tests\Feature\Views\Master\Documents;

use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MasterDocumentsShowPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_has_data(): void
    {
        $this->get("/documents/1")
            ->assertViewIs('master.documents.show')
            ->assertViewHas('document');
    }

    /** @test */
    public function user_can_see_the_page_if_document_is_ready(): void
    {
        $this->actingAs(make(User::class))
            ->get('/documents/1')
            ->assertOk();
    }

    /** @test */
    public function user_cant_see_the_page_if_document_is_not_ready(): void
    {
        $this->actingAs(make(User::class))
            ->get('/documents/' . create(Document::class, ['ready_' . LANG() => 0])->id)
            ->assertRedirect();
    }

    /** @test */
    public function master_can_see_the_page_if_document_is_not_ready(): void
    {
        $this->actingAs(create_user('master'))
            ->get('/documents/' . create(Document::class, ['ready_' . LANG() => 0])->id)
            ->assertOk();
    }

    /** @test */
    public function master_can_see_action_button(): void
    {
        $this->actingAs(create_user('master'))
            ->get('/documents/1')
            ->assertSee('<i class="fas fa-angle-left"></i>')
            ->assertSee('<i class="fas fa-pen"></i>');
    }

    /** @test */
    public function user_cant_see_action_button(): void
    {
        $this->get('/documents/1')
            ->assertDontSee('<i class="fas fa-angle-left"></i>')
            ->assertDontSee('<i class="fas fa-pen"></i>');
    }
}
