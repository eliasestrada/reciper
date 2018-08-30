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
    public function view_recipes_index_is_correct(): void
    {
        $this->get('/recipes')->assertViewIs('recipes.index');
    }

    /**
     * @test
     * @return void
     */
    public function auth_user_can_see_recipes_index_page(): void
    {
        $user = create(User::class);
        $this->actingAs($user)->get("/recipes")->assertOk();
    }

    /**
     * @test
     * @return void
     */
    public function guest_can_see_recipes_index_page(): void
    {
        $this->get('/recipes')->assertOk();
    }
}
