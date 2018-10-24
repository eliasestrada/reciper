<?php

namespace Tests\Feature\Views\Help;

use App\Models\Help;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class HelpShowPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function page_accessible(): void
    {
        $help_page_id = create(Help::class)->id;
        $this->get("/help/$help_page_id")->assertOk()->assertViewIs('help.show');
    }
}
