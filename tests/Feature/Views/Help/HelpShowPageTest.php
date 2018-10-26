<?php

namespace Tests\Feature\Views\Help;

use App\Models\Help;
use Tests\TestCase;

class HelpShowPageTest extends TestCase
{
    /**
     * @author Cho
     * @test
     */
    public function page_accessible(): void
    {
        $this->get('/help/1')->assertOk()->assertViewIs('help.show');
    }
}
