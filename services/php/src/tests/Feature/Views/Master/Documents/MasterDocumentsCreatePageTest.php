<?php

namespace Tests\Feature\Views\Master\Documents;

use Tests\TestCase;
use App\Models\User;
use App\Models\Document;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MasterDocumentsCreatePageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function master_can_see_the_page(): void
    {
        $this->actingAs(create_user('master'))
            ->get('/master/documents/create')
            ->assertViewIs('master.documents.create')
            ->assertOk();
    }

    /**
     * @test
     */
    public function user_cant_see_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get("/master/documents/create")
            ->assertRedirect();
    }

    /**
     * @test
     */
    public function master_can_create_document(): void
    {
        $data = ['title' => string_random(20), 'text' => string_random(100)];

        $this->actingAs(create_user('master'))
            ->post(action('Master\DocumentController@store'), $data);

        $this->assertDatabaseHas('documents', [
            _('title') => $data['title'],
            _('text') => $data['text'],
            _('ready') => 0,
        ]);
    }

    /**
     * @test
     */
    public function user_cant_delete_document(): void
    {
        $this->actingAs(make(User::class))
            ->delete(action('Master\DocumentController@destroy', [
                'id' => $document_id = create(Document::class)->id,
            ]))
            ->assertRedirect('/');
    }

    /**
     * @test
     */
    public function master_cant_delete_main_first_document(): void
    {
        $this->actingAs(create_user('master'))
            ->delete(action('Master\DocumentController@destroy', ['id' => 1]))
            ->assertRedirect('/master/documents/create');
    }
}
