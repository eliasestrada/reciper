<?php

namespace Tests\Feature\Views\Documents;

use Tests\TestCase;
use App\Models\User;
use App\Models\Document;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DocumentsShowPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function user_can_see_the_page_if_document_is_ready(): void
    {
        $this->actingAs(make(User::class))
            ->get('/documents/1')
            ->assertOk();
    }

    /**
     * @test
     */
    public function user_cant_see_the_page_if_document_is_not_ready(): void
    {
        $document_id = create(Document::class, [_('ready') => 0])->id;

        $this->actingAs(make(User::class))
            ->get("/documents/{$document_id}")
            ->assertRedirect();
    }

    /**
     * @test
     */
    public function master_can_see_the_page_if_document_is_not_ready(): void
    {
        $document_id = create(Document::class, [_('ready') => 0])->id;

        $this->actingAs(create_user('master'))
            ->get("/documents/${document_id}")
            ->assertOk();
    }
}
