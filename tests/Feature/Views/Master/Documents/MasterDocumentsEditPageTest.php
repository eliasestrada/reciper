<?php

namespace Tests\Feature\Views\Master\Documents;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MasterDocumentsEditPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_has_data(): void
    {
        $this->actingAs(create_user('master'))
            ->get("/master/documents/1/edit")
            ->assertOk()
            ->assertViewIs('master.documents.edit')
            ->assertViewHas('document');
    }

    /** @test */
    public function user_cannot_see_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get("/master/documents/1/edit")
            ->assertRedirect('/');
    }
}
