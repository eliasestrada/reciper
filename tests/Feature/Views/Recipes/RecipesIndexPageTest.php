<?php

namespace Tests\Feature\Views\Recipes;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RecipesIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * @return void
     */
    public function viewIsCorrect(): void
    {
        $this->get('/recipes')
            ->assertViewIs('recipes.index');
    }

    /**
     * Test for recipes page. View: resources/views/recipes/index
     * @return void
     * @test
     */
    public function authUserCanSeeRecipesIndexPage(): void
    {
        $this->actingAs(factory(User::class)->create())
            ->get("/recipes")
            ->assertOk();
    }

    /**
     * Test for recipes page. View: resources/views/recipes/index
     * @return void
     * @test
     */
    public function guestCanSeeRecipesIndexPage(): void
    {
        $this->get('/recipes')
            ->assertOk();
    }
}
