<?php

namespace Tests\Feature\Views\Help;

use Tests\TestCase;
use App\Models\Help;

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
        $this->get('/help');
        $this->assertNotNull(cache()->pull('help_list'));
        $this->assertNotNull(cache()->pull('help_categories'));
    }
}
