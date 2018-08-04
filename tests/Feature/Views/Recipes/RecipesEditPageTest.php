<?php

namespace Tests\Feature\Views\Recipes;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RecipesEditPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @param string $title
     * @return array
     */
    public function newRecipe(string $title): array
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

    /**
     * Test for edit recipe page. View: resources/views/recipes/edit
     * @return void
     * @test
     */
    public function authUserCanSeeRecipesEditPage(): void
    {
        $user = factory(User::class)->create();
        $recipe = factory(Recipe::class)->create(['user_id' => $user->id]);

        $this->actingAs(User::find($user->id))
            ->get("/recipes/$recipe->id/edit")
            ->assertOk()
            ->assertViewIs('recipes.edit');
    }

    /**
     * @test
     * @return void
     */
    public function recipeIsReadyButNotApprovedAfterPublishingByUser(): void
    {
        $user = factory(User::class)->create();

        $old_recipe = factory(Recipe::class)->create([
            'user_id' => $user->id,
            'ready_' . locale() => 0,
            'approved_' . locale() => 0,
        ]);
        $new_recipe = $this->newRecipe('New title by user');

        $this->actingAs($user)
            ->put(action('RecipesController@update', $old_recipe->id), $new_recipe)
            ->assertRedirect("/users/$user->id");

        $this->assertDatabaseHas('recipes', [
            'title_' . locale() => 'New title by user',
            'ready_' . locale() => 1,
            'approved_' . locale() => 0,
        ]);
    }

    /**
     * @test
     * @return void
     */
    public function recipeIsReadyAndApprovedAfterPublishingByAdmin(): void
    {
        $user = factory(User::class)->create(['admin' => 1]);
        $old_recipe = factory(Recipe::class)->create([
            'user_id' => $user->id,
            'ready_' . locale() => 0,
            'approved_' . locale() => 0,
        ]);
        $new_recipe = $this->newRecipe('Some title by admin');

        $this->actingAs($user)
            ->put(action('RecipesController@update', $old_recipe->id), $new_recipe)
            ->assertRedirect("/users/$user->id");

        $this->assertDatabaseHas('recipes', [
            'title_' . locale() => 'Some title by admin',
            'ready_' . locale() => 1,
            'approved_' . locale() => 1,
        ]);
    }
}
