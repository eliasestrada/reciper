<?php

namespace Tests\Feature\Views\Master\Documents;

use Tests\TestCase;
use App\Models\User;
use App\Models\Document;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MasterDocumentsEditPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function master_can_see_the_page(): void
    {
        $this->actingAs(create_user('master'))
            ->get("/master/documents/1/edit")
            ->assertOk()
            ->assertViewIs('master.documents.edit');
    }

    /**
     * @test
     */
    public function user_cannot_see_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get("/master/documents/1/edit")
            ->assertRedirect();
    }

    /**
     * @test
     */
    public function master_can_move_documents_to_drafts_by_updating_document(): void
    {
        $data = ['title' => string_random(20), 'text' => string_random(100)];
        $doc = create(Document::class);

        $this->actingAs(create_user('master'))
            ->put(action('Master\DocumentController@update', ['id' => $doc->id]), $data);

        $this->assertDatabaseHas('documents', [
            _('title') => $data['title'],
            _('text') => $data['text'],
            _('ready') => 0,
        ]);
    }

    /**
     * @test
     */
    public function master_cant_move_main_first_document_to_drafts(): void
    {
        $data = ['title' => string_random(10), 'text' => string_random(100)];

        $this->actingAs(create_user('master'))
            ->put(action('Master\DocumentController@update', [
                'id' => Document::first()->id,
            ]), $data);

        $this->assertDatabaseHas('documents', ['id' => 1, _('ready') => 1]);
    }

    /**
     * @test
     */
    public function master_can_delete_document(): void
    {
        $this->actingAs(create_user('master'))
            ->delete(action('Master\DocumentController@destroy', [
                'id' => $document_id = create(Document::class)->id,
            ]));
        $this->assertDatabaseMissing('documents', ['id' => $document_id]);
    }
}
