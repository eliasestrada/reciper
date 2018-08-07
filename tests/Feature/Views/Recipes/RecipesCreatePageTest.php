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
     * resources/views/recipes/create
     * @test
     * @return void
     */
    public function view_recipes_create_has_data(): void
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get('/recipes/create')
            ->assertViewIs('recipes.create')
            ->assertViewHas('meal', Meal::get(['id', 'name_' . locale()]));
    }

    /**
     * resources/views/recipes/create
     * @test
     * @return void
     */
    public function auth_user_can_see_recipes_create_page(): void
    {
        $this->actingAs(factory(User::class)->create())
            ->get('/recipes/create')
            ->assertOk();
    }

    /**
     * resources/views/recipes/create
     * @test
     * @return void
     */
    public function created_recipe_by_user_is_not_approved(): void
    {
        $recipe = $this->new_recipe('Hello world');

        $this->actingAs(factory(User::class)->create())
            ->post(action('RecipesController@store'), $recipe)
            ->assertRedirect();
        $this->assertDatabaseHas('recipes', [
            'title_' . locale() => 'Hello world',
            'approved_' . locale() => 0,
            'ready_' . locale() => 0,
        ]);
    }

    /**
     * resources/views/recipes/create
     * @test
     * @return void
     */
    public function created_recipe_by_admin_approved(): void
    {
        $recipe = $this->new_recipe('Hello people');

        $this->actingAs(factory(User::class)->create(['admin' => 1]))
            ->post(action('RecipesController@store'), $recipe)
            ->assertRedirect();

        $this->assertDatabaseHas('recipes', [
            'title_' . locale() => 'Hello people',
            'approved_' . locale() => 1,
            'ready_' . locale() => 0,
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
