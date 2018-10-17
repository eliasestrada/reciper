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

    private $user;
    private $new_recipe;

    public function setUp()
    {
        parent::setUp();

        $this->user = create_user();
        $this->new_recipe = [
            'title' => str_random(20),
            'time' => 120,
            'meal' => 1,
            'ready' => 1,
            'ingredients' => str_random(50),
            'intro' => str_random(100),
            'text' => str_random(200),
            'image' => '',
            'categories' => [0 => 2, 1 => 3],
        ];
    }

    /** @test */
    public function view_has_data(): void
    {
        $recipe = create(Recipe::class, [
            'ready_' . lang() => 0,
            'approved_' . lang() => 0,
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)->get("/recipes/{$recipe->id}/edit");

        $response->assertViewIs('recipes.edit')
            ->assertViewHasAll([
                'meal' => Meal::getWithCache(),
                'recipe' => Recipe::with('categories', 'meal')
                    ->whereId($recipe->id)
                    ->first(),
            ]);
    }

    /** @test */
    public function author_cant_see_the_page(): void
    {
        $recipe = create(Recipe::class, ['user_id' => $this->user->id]);

        $this->actingAs($this->user)
            ->get("/recipes/$recipe->id/edit")
            ->assertRedirect();
    }

    /** @test */
    public function recipe_is_ready_but_not_approved_after_publishing_by_user(): void
    {
        $old_recipe = create(Recipe::class, [
            'approved_' . lang() => 0,
            'ready_' . lang() => 0,
            'user_id' => $this->user->id,
        ]);

        $this->actingAs($this->user)
            ->put(action('RecipesController@update', $old_recipe->id), $this->new_recipe)
            ->assertRedirect('/users/other/my-recipes');

        $this->assertDatabaseHas('recipes', [
            'title_' . lang() => $this->new_recipe['title'],
            'ready_' . lang() => 1,
            'approved_' . lang() => 0,
        ]);
    }

    /** @test */
    public function recipe_can_be_saved(): void
    {
        $this->new_recipe['ready'] = 0;
        $recipe = create(Recipe::class, [
            'approved_' . lang() => 0,
            'ready_' . lang() => 0,
            'user_id' => $this->user->id,
        ]);

        $this->actingAs($this->user)
            ->followingRedirects()
            ->put(action('RecipesController@update', $recipe->id), $this->new_recipe)
            ->assertSeeText(trans('recipes.saved'));

        $this->assertDatabaseHas('recipes', [
            'id' => $recipe->id,
            'ready_' . lang() => 0,
            'approved_' . lang() => 0,
        ]);
    }

    /** @test */
    public function recipe_is_ready_and_approved_after_publishing_by_admin(): void
    {
        $admin = create_user('admin');

        $recipe_before = create(Recipe::class, [
            'user_id' => $admin->id,
            'ready_' . lang() => 0,
            'approved_' . lang() => 0,
        ]);

        $this->actingAs($admin)
            ->put(action('RecipesController@update', $recipe_before->id), $this->new_recipe)
            ->assertRedirect('/users/other/my-recipes');

        $this->assertDatabaseHas('recipes', [
            'title_' . lang() => $this->new_recipe['title'],
            'ready_' . lang() => 1,
            'approved_' . lang() => 1,
        ]);
    }

    /** @test */
    public function recipe_can_be_moved_to_drafts_by_author(): void
    {
        $recipe = create(Recipe::class, ['user_id' => $this->user->id]);

        $this->actingAs($this->user)
            ->put(action('RecipesController@update', ['recipe' => $recipe->id]));

        $this->assertDatabaseHas('recipes', [
            'id' => $recipe->id,
            'approved_' . lang() => 0,
            'ready_' . lang() => 0,
        ]);
    }

    /** @test */
    public function recipe_cant_be_moved_to_drafts_by_other_users(): void
    {
        $user = create_user();
        $recipe = create(Recipe::class, ['user_id' => $this->user->id]);

        $this->actingAs($user)
            ->put(action('RecipesController@update', ['recipe' => $recipe->id]));

        $this->assertDatabaseHas('recipes', [
            'id' => $recipe->id,
            'approved_' . lang() => 1,
            'ready_' . lang() => 1,
        ]);
    }
}
