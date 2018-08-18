<?php

namespace Tests\Feature\Views\Recipes;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RecipesShowPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * resources/views/recipes/show
     * @test
     * @return void
     */
    public function view_recipes_show_has_data(): void
    {
        $recipe = create(Recipe::class);

        $this->get("/recipes/$recipe->id")
            ->assertViewIs('recipes.show')
            ->assertViewHas('recipe',
                Recipe::with('likes', 'categories', 'user')
                    ->whereId($recipe->id)
                    ->first()
            );
    }

    /**
     * resources/views/recipes/show
     * @test
     * @return void
     */
    public function auth_user_can_see_recipe_show_page(): void
    {
        $user = create(User::class);
        $user2 = create(User::class);
        $recipe = create(Recipe::class, ['user_id' => $user->id]);
        $recipe2 = create(Recipe::class, ['user_id' => $user2->id]);

        $this->actingAs($user)->get("/recipes/$recipe->id")->assertOk();
        $this->actingAs($user2)->get("/recipes/$recipe->id")->assertOk();
    }

    /**
     * resources/views/recipes/show
     * @test
     * @return void
     */
    public function guest_xan_see_recipes_show_page(): void
    {
        $recipe = create(Recipe::class);
        $this->get("/recipes/$recipe->id")->assertOk();
    }
}
