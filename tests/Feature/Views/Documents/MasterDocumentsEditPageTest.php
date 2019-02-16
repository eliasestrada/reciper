<?php

namespace Tests\Feature\Views\Documents;

use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MasterDocumentsEditPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @author Cho
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
     * @author Cho
     * @test
     */
    public function user_cannot_see_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get("/master/documents/1/edit")
            ->assertRedirect();
    }

    /**
     * @author Cho
     * @test
     */
    public function master_can_move_documents_to_drafts_by_updating_document(): void
    {
        $data = ['title' => str_random(20), 'text' => str_random(100)];
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
     * @author Cho
     * @test
     */
    public function master_cant_move_main_first_document_to_drafts(): void
    {
        $data = ['title' => str_random(10), 'text' => str_random(100)];

        $this->actingAs(create_user('master'))
            ->put(action('Master\DocumentController@update', [
                'id' => Document::first()->id,
            ]), $data);

        $this->assertDatabaseHas('documents', ['id' => 1, _('ready') => 1]);
    }

    /**
     * @author Cho
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
