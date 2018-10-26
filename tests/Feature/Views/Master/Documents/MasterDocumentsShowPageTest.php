<?php

namespace Tests\Feature\Views\Master\Documents;

use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MasterDocumentsShowPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @author Cho
     * @test
     */
    public function user_can_see_the_page_if_document_is_ready(): void
    {
        $this->actingAs(make(User::class))
            ->get('/documents/1')
            ->assertOk();
    }

    /**
     * @author Cho
     * @test
     */
    public function user_cant_see_the_page_if_document_is_not_ready(): void
    {
        $document_id = create(Document::class, ['ready_' . LANG() => 0])->id;

        $this->actingAs(make(User::class))
            ->get("/documents/$document_id")
            ->assertRedirect();
    }

    /**
     * @author Cho
     * @test
     */
    public function master_can_see_the_page_if_document_is_not_ready(): void
    {
        $document_id = create(Document::class, ['ready_' . LANG() => 0])->id;

        $this->actingAs(create_user('master'))
            ->get("/documents/$document_id")
            ->assertOk();
    }
}
