<?php

namespace Tests\Feature\Views\Pages;

use Tests\TestCase;

class PagesHomePageTest extends TestCase
{
    /** @test */
    public function view_has_data(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertViewIs('pages.home')
            ->assertViewHasAll(['recipes', 'users']);
    }
}
