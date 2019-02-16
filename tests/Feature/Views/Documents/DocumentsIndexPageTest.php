<?php

namespace Tests\Feature\Views\Documents;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DocumentsIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @author Cho
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
     * @author Cho
     * @test
     */
    public function guest_can_see_the_page(): void
    {
        $this->get('/documents')->assertOk();
    }
}
