<?php

namespace Tests\Feature\Views\Pages;

use Tests\TestCase;

class PagesHomePageTest extends TestCase
{
    /**
     * @test
     */
    public function view_is_accessable(): void
    {
        $this->get('/')->assertOk()->assertViewIs('pages.home');
    }
}
