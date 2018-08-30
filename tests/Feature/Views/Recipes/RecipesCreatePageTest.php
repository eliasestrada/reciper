<?php

namespace Tests\Feature\Views\Recipes;

use App\Models\Meal;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RecipesCreatePageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * @return void
     */
    public function view_recipes_create_has_data(): void
    {
        $this->actingAs(create(User::class))
            ->get('/recipes/create')
            ->assertViewIs('recipes.create')
            ->assertViewHas('meal', Meal::get(['id', 'name_' . lang()]));
    }

    /**
     * @test
     * @return void
     */
    public function auth_user_can_see_recipes_create_page(): void
    {
        $this->actingAs(create(User::class))
            ->get('/recipes/create')
            ->assertOk();
    }

    /**
     * @test
     * @return void
     */
    public function created_recipe_by_user_is_not_approved(): void
    {
        $recipe = $this->new_recipe('Hello world');

        $this->actingAs(create(User::class))
            ->post(action('RecipesController@store'), $recipe)
            ->assertRedirect();
        $this->assertDatabaseHas('recipes', [
            'title_' . lang() => 'Hello world',
            'approved_' . lang() => 0,
            'ready_' . lang() => 0,
        ]);
    }

    /**
     * @test
     * @return void
     */
    public function created_recipe_by_admin_approved(): void
    {
        $recipe = $this->new_recipe('Hello people');

        $this->actingAs(create(User::class, ['admin' => 1]))
            ->post(action('RecipesController@store'), $recipe)
            ->assertRedirect();

        $this->assertDatabaseHas('recipes', [
            'title_' . lang() => 'Hello people',
            'approved_' . lang() => 1,
            'ready_' . lang() => 0,
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
            'ingredients' => '',
            'intro' => '',
            'text' => '',
            'categories' => [0 => 1],
        ];
    }
}
