<?php

namespace Tests\Feature\Views\Recipes;

use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RecipesCreatePageTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * @param string $title
	 * @return array
	 */
	public function newRecipe(string $title) : array
	{
		return [
			'title' => $title,
			'time' => 120,
			'meal' => 1,
			'ingredients' => '',
			'intro' => '',
			'text' => '',
			'categories' => [ 0 => 1 ]
		];
	}

	/**
	 * Test for create recipe page. View: resources/views/recipes/create
	 * @return void
	 * @test
	 */
	public function authUserCanSeeRecipesCreatePage() : void
    {
		$this->actingAs(User::find(factory(User::class)->create()->id))
			->get('/recipes/create')
			->assertOk()
			->assertViewIs('recipes.create');
	}

	/**
	 * @test
	 * @return void
	 */
	public function createdRecipeByUserIsNotApproved() : void
	{
		$recipe = $this->newRecipe('Hello world');

		$this->actingAs(User::find(factory(User::class)->create()->id))
			->post(action('RecipesController@store'), $recipe)
			->assertRedirect();
		$this->assertDatabaseHas('recipes', [
			'title_' . locale() => 'Hello world',
			'approved_' . locale() => 0,
			'ready_' . locale() => 0
		]);
	}

	/**
	 * @test
	 * @return void
	 */
	public function createdRecipeByAdminApproved() : void
	{
		$recipe = $this->newRecipe('Hello people');

		$this->actingAs(User::find(factory(User::class)->create(['admin' => 1])->id))
			->post(action('RecipesController@store'), $recipe)
			->assertRedirect();

		$this->assertDatabaseHas('recipes', [
			'title_' . locale() => 'Hello people',
			'approved_' . locale() => 1,
			'ready_' . locale() => 0
		]);
	}
}
