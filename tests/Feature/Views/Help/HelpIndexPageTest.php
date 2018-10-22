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
                'help' => Help::selectBasic()->orderBy('title')->get()->toArray(),
                'help_categories' => HelpCategory::selectBasic()->get()->toArray(),
            ]);
    }

    /** @test */
    public function queries_are_cached_when_someone_visits_the_page(): void
    {
        $this->assertNull(cache()->get('help'));
        $this->assertNull(cache()->get('help_categories'));
        $this->get('/help');
        $this->assertNotNull(cache()->pull('help'));
        $this->assertNotNull(cache()->pull('help_categories'));
    }
}
