<?php

namespace Tests\Feature\Views\Help;

use App\Models\Help;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class HelpShowPageTest extends TestCase
{
    use DatabaseTransactions;

    private $help;

    public function setUp()
    {
        parent::setUp();
        $this->help = create(Help::class);
    }

    /** @test */
    public function page_accessible_and_has_data(): void
    {
        $this->get("/help/{$this->help->id}")
            ->assertOk()
            ->assertViewIs('help.show')
            ->assertViewHas('help', Help::find($this->help->id));
    }
}
