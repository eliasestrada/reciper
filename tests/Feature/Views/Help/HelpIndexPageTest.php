<?php

namespace Tests\Feature\Views\Help;

use App\Models\Help;
use Tests\TestCase;

class HelpIndexPageTest extends TestCase
{
    /**
     * @author Cho
     * @test
     */
    public function page_is_accessible(): void
    {
        $this->get('/help')
            ->assertOk()
            ->assertViewIs('help.index');
    }

    /**
     * @author Cho
     * @test
     */
    public function queries_are_cached_when_someone_visits_the_page(): void
    {
        $this->assertNull(cache()->get('help'));
        $this->assertNull(cache()->get('help_categories'));
        $this->get('/help');
        $this->assertNotNull(cache()->pull('help'));
        $this->assertNotNull(cache()->pull('help_categories'));
    }
}
