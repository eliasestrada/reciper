<?php

namespace Tests\Feature\Views\Master\Documents;

use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MasterDocumentsCreatePageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_has_a_correct_path(): void
    {
        $this->actingAs(create_user('master'))
            ->get('/master/documents/create')
            ->assertOk()
            ->assertViewIs('master.documents.create');
    }

    /** @test */
    public function user_cant_see_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get("/master/documents/create")
            ->assertRedirect('/');
    }

    /** @test */
    public function master_can_create_document(): void
    {
        $data = ['title' => str_random(20), 'text' => str_random(100)];

        $this->actingAs(create_user('master'))
            ->post(action('Master\DocumentsController@store'), $data);

        $this->assertDatabaseHas('documents', [
            'title_' . LANG() => $data['title'],
            'text_' . LANG() => $data['text'],
            'ready_' . LANG() => 0,
        ]);
    }

    /** @test */
    public function master_can_delete_document(): void
    {
        $this->actingAs(create_user('master'))
            ->delete(action('Master\DocumentsController@destroy', [
                'id' => $document_id = create(Document::class)->id,
            ]));
        $this->assertDatabaseMissing('documents', ['id' => $document_id]);
    }

    /** @test */
    public function user_cant_delete_document(): void
    {
        $this->actingAs(make(User::class))
            ->followingRedirects()
            ->delete(action('Master\DocumentsController@destroy', [
                'id' => $document_id = create(Document::class)->id,
            ]))
            ->assertSeeText(trans('messages.access_denied_only_master'));
    }

    /** @test */
    public function master_cant_delete_main_first_document(): void
    {
        $this->actingAs(create_user('master'))
            ->followingRedirects()
            ->delete(action('Master\DocumentsController@destroy', ['id' => 1]))
            ->assertSeeText(trans('documents.cant_delete_first_doc'));
    }

    /** @test */
    public function master_can_move_documents_to_drafts(): void
    {
        $data = ['title' => str_random(20), 'text' => str_random(100)];
        $doc = create(Document::class);

        $this->actingAs(create_user('master'))
            ->put(action('Master\DocumentsController@update', ['id' => $doc->id]), $data);

        $this->assertDatabaseHas('documents', [
            'title_' . LANG() => $data['title'],
            'text_' . LANG() => $data['text'],
            'ready_' . LANG() => 0,
        ]);
    }

    /** @test */
    public function master_cant_move_main_first_document_to_drafts(): void
    {
        $data = ['title' => str_random(10), 'text' => str_random(100)];

        $this->actingAs(create_user('master'))
            ->put(action('Master\DocumentsController@update', [
                'id' => Document::first()->id,
            ]), $data);

        $this->assertDatabaseHas('documents', ['id' => 1, 'ready_' . LANG() => 1]);
    }
}
