<?php

namespace Tests\Feature\Views\Master\Documents;

use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MasterDocumentsIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_index_page_is_correct(): void
    {
        $master = create_user('master');

        $this->actingAs($master)
            ->get("/master/documents")
            ->assertViewIs('master.documents.index')
            ->assertViewHas('ready_docs', Document::query()->ready(1)->paginate(20)->onEachSide(1))
            ->assertViewHas('unready_docs', Document::query()->ready(0)->paginate(20)->onEachSide(1));
    }

    /** @test */
    public function user_cant_see_index_page(): void
    {
        $user = make(User::class);

        $this->actingAs($user)
            ->get('/master/documents')
            ->assertRedirect('/');
    }

    /** @test */
    public function master_can_see_index_page(): void
    {
        $this->actingAs(create_user('master'))
            ->get('/master/documents')
            ->assertOk();
    }
}
