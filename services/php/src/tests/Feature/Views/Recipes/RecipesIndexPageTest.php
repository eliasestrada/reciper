<?php

namespace Tests\Feature\Views\Recipes;

use Tests\TestCase;

class RecipesIndexPageTest extends TestCase
{
    /**
     * @test
     */
    public function view_is_accessable(): void
    {
        $this->get('/recipes')->assertViewIs('recipes.index')->assertOk();
    }

    /**
     * @test
     */
    public function recipe_can_be_created_by_auth(): void
    {
        $user = create_user();

        $this->actingAs($user)->post(action('RecipeController@store'), [
            'title' => $title = string_random(10),
        ]);

        $this->assertDatabaseHas('recipes', [
            _('ready') => 0,
            _('approved') => 0,
            _('title') => $title,
            'user_id' => $user->id,
        ]);
    }

    /**
     * @test
     */
    public function recipe_cant_be_created_by_guest(): void
    {
        $this->post(action('RecipeController@store'), [
            'title' => $title = string_random(10),
        ]);

        $this->assertDatabaseMissing('recipes', [_('title') => $title]);
    }
}
