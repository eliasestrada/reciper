<?php

namespace Tests\Feature\Views\Recipes;

use Tests\TestCase;

class RecipesIndexPageTest extends TestCase
{
    /** @test */
    public function view_is_accessable(): void
    {
        $this->get('/recipes')->assertViewIs('recipes.index')->assertOk();
    }
}
