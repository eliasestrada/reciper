<?php

namespace Tests\Feature\Views\Help;

use App\Models\Help;
use App\Models\HelpCategory;
use Tests\TestCase;

class HelpIndexPageTest extends TestCase
{
    /** @test */
    public function page_accessible_and_has_data(): void
    {
        $this->get('/help')
            ->assertOk()
            ->assertViewIs('help.index')
            ->assertViewHasAll([
                'help' => Help::selectBasic()->orderBy('title')->get(),
                'help_categories' => HelpCategory::selectBasic()->get(),
            ]);
    }
}
