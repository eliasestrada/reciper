<?php

namespace Tests\Feature\Views\Recipes;

use App\Models\Meal;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RecipesEditPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_recipes_edit_has_data(): void
    {
        $user = create(User::class);
        $recipe = create(Recipe::class, ['user_id' => $user->id]);

        $response = $this->actingAs($user)->get("/recipes/$recipe->id/edit");

        $expected_recipe = Recipe::with('categories', 'meal')
            ->whereId($recipe->id)
            ->first();

        $meal = Meal::get(['id', 'name_' . lang()]);

        $response->assertViewIs('recipes.edit')
            ->assertViewHasAll([
                'meal' => $meal,
                'recipe' => $expected_recipe,
            ]);
    }

    /** @test */
    public function auth_user_can_see_recipes_edit_page(): void
    {
        $user = create(User::class);
        $recipe = create(Recipe::class, ['user_id' => $user->id]);

        $this->actingAs($user)
            ->get("/recipes/$recipe->id/edit")
            ->assertOk();
    }

    /** @test */
    public function recipe_is_ready_but_not_approved_after_publishing_by_user(): void
    {
        $user = create(User::class);

        $old_recipe = create(Recipe::class, [
            'user_id' => $user->id,
            'ready_' . lang() => 0,
            'approved_' . lang() => 0,
        ]);
        $new_recipe = $this->new_recipe('New title by user');

        $this->actingAs($user)
            ->put(action('RecipesController@update', $old_recipe->id), $new_recipe)
            ->assertRedirect("/users/$user->id");

        $this->assertDatabaseHas('recipes', [
            'title_' . lang() => 'New title by user',
            'ready_' . lang() => 1,
            'approved_' . lang() => 0,
        ]);
    }

    /** @test */
    public function recipe_is_ready_and_approved_after_publishing_by_admin(): void
    {
        $user = create(User::class, ['admin' => 1]);
        $old_recipe = create(Recipe::class, [
            'user_id' => $user->id,
            'ready_' . lang() => 0,
            'approved_' . lang() => 0,
        ]);
        $new_recipe = $this->new_recipe('Some title by admin');

        $this->actingAs($user)
            ->put(action('RecipesController@update', $old_recipe->id), $new_recipe)
            ->assertRedirect("/users/$user->id");

        $this->assertDatabaseHas('recipes', [
            'title_' . lang() => 'Some title by admin',
            'ready_' . lang() => 1,
            'approved_' . lang() => 1,
        ]);
    }

    /**
     * @param string $title
     * @return array
     */
    public function new_recipe(string $title): array
    {
        return [
            'title' => $title,
            'time' => 120,
            'meal' => 1,
            'ready' => 1,
            'ingredients' => 'Minimum 20 Lorem ipsum, dolor sit amet consectetur adipisdgfgsicing',
            'intro' => 'Minimum 20, dolor sit amet consectetur adipisdgfgdsgdsicing elit',
            'text' => 'Minimum 80 chars dolor sit amet adipisicing elit adipisicing amet lorefana more text to fill the field',
            'categories' => [0 => 1, 1 => 2],
        ];
    }
}
