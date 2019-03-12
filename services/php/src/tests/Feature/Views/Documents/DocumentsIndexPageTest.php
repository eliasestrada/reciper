<?php

namespace Tests\Feature\Views\Documents;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DocumentsIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function master_can_see_the_page(): void
    {
        $this->actingAs(create_user('master'))
            ->get("/documents")
            ->assertOk()
            ->assertViewIs('documents.index');
    }

    /**
     * @test
     */
    public function guest_can_see_the_page(): void
    {
        $this->get('/documents')->assertOk();
    }
}
