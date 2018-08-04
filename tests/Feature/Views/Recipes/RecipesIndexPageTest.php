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
     * resources/views/recipes/index
     * @test
     * @return void
     */
    public function viewRecipesIndexIsCorrect(): void
    {
        $this->get('/recipes')->assertViewIs('recipes.index');
    }

    /**
     * resources/views/recipes/index
     * @test
     * @return void
     */
    public function authUserCanSeeRecipesIndexPage(): void
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)->get("/recipes")->assertOk();
    }

    /**
     * resources/views/recipes/index
     * @test
     * @return void
     */
    public function guestCanSeeRecipesIndexPage(): void
    {
        $this->get('/recipes')->assertOk();
    }
}
