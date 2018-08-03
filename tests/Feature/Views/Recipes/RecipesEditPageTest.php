<?php

namespace Tests\Feature\Views\Recipes;

use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RecipesEditPageTest extends TestCase
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
			'ready' => 1,
			'ingredients' => 'Minimum 20 Lorem ipsum, dolor sit amet consectetur adipisdgfgsicing',
			'intro' => 'Minimum 20, dolor sit amet consectetur adipisdgfgdsgdsicing elit',
			'text' => 'Minimum 80 chars dolor sit amet adipisicing elit adipisicing amet lorefana more text to fill the field',
			'categories' => [ 0 => 1, 1 => 2 ]
		];
	}

	/**
	 * Test for edit recipe page. View: resources/views/recipes/edit
	 * @return void
	 * @test
	 */
	public function authUserCanSeeRecipesEditPage() : void
    {
		$user = User::find(factory(User::class)->create()->id);
		$recipe = factory(Recipe::class)->create(['user_id' => $user->id]);

		$this->actingAs($user)
			->get("/recipes/$recipe->id/edit")
			->assertOk()
			->assertViewIs('recipes.edit');
	}

	/**
	 * @test
	 * @return void
	 */
	public function recipeIsReadyAfterPublishing() : void
	{
		$user = User::find(factory(User::class)->create()->id);
		$old_recipe = factory(Recipe::class)->create(['user_id' => $user->id]);
		$new_recipe = $this->newRecipe('New title');

		$this->actingAs($user)
			->put(action('RecipesController@update', $old_recipe->id), $new_recipe)
			->assertRedirect("/users/$user->id");

		$this->assertDatabaseHas('recipes', ['title_' . locale() => 'New title']);
	}
}
