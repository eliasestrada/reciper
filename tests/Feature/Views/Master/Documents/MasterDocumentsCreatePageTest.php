<?php

namespace Tests\Feature\Views\Master\Documents;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MasterDocumentsCreatePageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_has_a_correct_path(): void
    {
        $master = create_user('master');

        $this->actingAs($master)
            ->get('/master/documents/create')
            ->assertOk()
            ->assertViewIs('master.documents.create');
    }

    /** @test */
    public function user_cant_see_the_page(): void
    {
        $user = make(User::class);

        $this->actingAs($user)
            ->get("/master/documents/create")
            ->assertRedirect('/');
    }
}
