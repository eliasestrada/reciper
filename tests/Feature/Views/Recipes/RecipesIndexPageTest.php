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
    public function view_recipes_index_is_correct(): void
    {
        $this->get('/recipes')->assertViewIs('recipes.index');
    }

    /**
     * resources/views/recipes/index
     * @test
     * @return void
     */
    public function auth_user_can_see_recipes_index_page(): void
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)->get("/recipes")->assertOk();
    }

    /**
     * resources/views/recipes/index
     * @test
     * @return void
     */
    public function guest_can_see_recipes_index_page(): void
    {
        $this->get('/recipes')->assertOk();
    }
}
