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
    public function viewHasData(): void
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get('/recipes/create')
            ->assertOk()
            ->assertViewIs('recipes.create')
            ->assertViewHas('meal', Meal::get(['id', 'name_' . locale()]));
    }

    /**
     * Test for create recipe page. View: resources/views/recipes/create
     * @return void
     * @test
     */
    public function authUserCanSeeRecipesCreatePage(): void
    {
        $this->actingAs(factory(User::class)->create())
            ->get('/recipes/create')
            ->assertOk();
    }

    /**
     * @test
     * @return void
     */
    public function createdRecipeByUserIsNotApproved(): void
    {
        $recipe = $this->newRecipe('Hello world');

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
     * @test
     * @return void
     */
    public function createdRecipeByAdminApproved(): void
    {
        $recipe = $this->newRecipe('Hello people');

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
    public function newRecipe(string $title): array
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
