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
    private $users_recipe;

    public function setUp()
    {
        parent::setUp();

        $this->user = create_user();
        $this->users_recipe = create(Recipe::class, ['user_id' => $this->user->id]);
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
                'meal' => Meal::get(['id', 'name_' . lang()]),
                'recipe' => Recipe::with('categories', 'meal')
                    ->whereId($recipe->id)
                    ->first(),
            ]);
    }

    /** @test */
    public function author_cant_see_the_page(): void
    {
        $this->actingAs($this->user)
            ->get("/recipes/{$this->users_recipe->id}/edit")
            ->assertRedirect();
    }

    /** @test */
    public function recipe_is_ready_but_not_approved_after_publishing_by_user(): void
    {
        $old_recipe = create(Recipe::class, [
            'approved_' . lang() => 0,
            'ready_ru' => 0,
            'user_id' => $this->user->id,
        ]);
        $updated_recipe = $this->new_recipe(1);

        $this->actingAs($this->user)
            ->put(action('RecipesController@update', $old_recipe->id), $updated_recipe)
            ->assertRedirect('/users/other/my-recipes');

        $this->assertDatabaseHas('recipes', [
            'title_' . lang() => $updated_recipe['title'],
            'ready_' . lang() => 1,
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

        $recipe_after = $this->new_recipe(1);

        $this->actingAs($admin)
            ->put(action('RecipesController@update', $recipe_before->id), $recipe_after)
            ->assertRedirect('/users/other/my-recipes');

        $this->assertDatabaseHas('recipes', [
            'title_' . lang() => $recipe_after['title'],
            'ready_' . lang() => 1,
            'approved_' . lang() => 1,
        ]);
    }

    /** @test */
    public function recipe_can_be_moved_to_drafts_by_author(): void
    {
        $this->actingAs($this->user)
            ->put(action('RecipesController@update', ['recipe' => $this->users_recipe->id]));

        $this->assertDatabaseHas('recipes', [
            'id' => $this->users_recipe->id,
            'approved_' . lang() => 0,
            'ready_' . lang() => 0,
        ]);
    }

    /** @test */
    public function recipe_cant_be_moved_to_drafts_by_other_users(): void
    {
        $user = create_user();

        $this->actingAs($user)
            ->put(action('RecipesController@update', ['recipe' => $this->users_recipe->id]));

        $this->assertDatabaseHas('recipes', [
            'id' => $this->users_recipe->id,
            'approved_' . lang() => 1,
            'ready_' . lang() => 1,
        ]);
    }

    /**
     * @param int $ready
     * @return array
     */
    public function new_recipe(int $ready = 0): array
    {
        return [
            'title' => str_random(20),
            'time' => 120,
            'meal' => 1,
            'ready' => $ready == 1 ? 1 : 0,
            'ingredients' => str_random(50),
            'intro' => str_random(100),
            'text' => str_random(200),
            'categories' => [0 => 1, 1 => 2],
        ];
    }
}
