<?php

namespace Tests\Feature\Auth\Users\Pages\CanSee;

use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserCanSeeRecipesPages extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test for create recipe page. View: resources/views/recipes/create
	 * @return void
	 * @test
	 */
	public function authUserCanSeeRecipesCreatePage() : void
    {
		$user = User::find(factory(User::class)->create()->id);
	
		$this->actingAs($user)
			->get('/recipes/create')
			->assertSuccessful()
			->assertViewIs('recipes.create');
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
			->assertSuccessful()
			->assertViewIs('recipes.edit');
	}

	/**
	 * Test for show recipe page. View: resources/views/recipes/show
	 * @return void
	 * @test
	 */
	public function authUserCanSeeRecipeShowPage() : void
    {
		$user = User::find(factory(User::class)->create()->id);
		$user2 = User::find(factory(User::class)->create()->id);
		$recipe = factory(Recipe::class)->create(['user_id' => $user->id]);
		$recipe2 = factory(Recipe::class)->create(['user_id' => $user2->id]);

		$this->actingAs($user)
			->get("/recipes/$recipe->id")
			->assertSuccessful()
			->assertViewIs('recipes.show');

		$this->actingAs($user2)
			->get("/recipes/$recipe->id")
			->assertSuccessful()
			->assertViewIs('recipes.show');
	}

	/**
	 * Test for recipes page. View: resources/views/recipes/index
	 * @return void
	 * @test
	 */
	public function authUserCanSeeRecipesPage() : void
    {
		$user = User::find(factory(User::class)->create()->id);

		$this->actingAs($user)
			->get("/recipes")
			->assertSuccessful()
			->assertViewIs('recipes.index');
	}
}
