<?php

namespace Tests\Feature\Views\Help;

use App\Models\Help;
use App\Models\HelpCategory;
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
            ->assertViewHasAll([
                'help' => Help::orderBy('title_' . LANG)->get(['id', 'help_category_id', 'title_' . LANG]),
                'help_categories' => HelpCategory::get(),
            ]);
    }
}
