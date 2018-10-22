<?php

namespace Tests\Feature\Views\Recipes;

use App\Models\User;
use Tests\TestCase;

class RecipesIndexPageTest extends TestCase
{
    /** @test */
    public function view_has_correct_data(): void
    {
        $this->get('/recipes')
            ->assertViewIs('recipes.index')
            ->assertViewHas('favs');
    }

    /** @test */
    public function auth_user_can_see_the_page(): void
    {
        $this->actingAs(make(User::class))->get("/recipes")->assertOk();
    }
}
