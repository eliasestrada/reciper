<?php

namespace Tests\Feature\Views\Help;

use App\Models\Help;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class HelpIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function page_accessible_and_has_data(): void
    {
        $this->get('/help')
            ->assertOk()
            ->assertViewIs('help.index')
            ->assertViewHas('help', Help::get(['id', 'title_' . lang()]));
    }
}
