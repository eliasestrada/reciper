<?php

namespace Tests\Feature\Views\Help;

use Tests\TestCase;
use App\Models\Help;

class HelpShowPageTest extends TestCase
{
    /**
     * @test
     */
    public function page_is_accessible(): void
    {
        $this->get('/help/1')->assertOk()->assertViewIs('help.show');
    }
}
