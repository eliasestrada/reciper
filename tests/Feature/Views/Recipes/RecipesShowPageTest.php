<?php

namespace Tests\Feature\Views\Recipes;

use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RecipesShowPageTest extends TestCase
{
	use DatabaseTransactions;

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
			->assertOk()
			->assertViewIs('recipes.show');

		$this->actingAs($user2)
			->get("/recipes/$recipe->id")
			->assertOk()
			->assertViewIs('recipes.show');
	}

	/**
	 * Test for show recipe page. View: resources/views/recipes/show
	 * @return void
	 * @test
	 */
	public function guestCanSeeRecipesShowPage() : void
    {
		$recipe = factory(Recipe::class)->create([
			'ready_ru' => 1,
			'ready_en' => 1,
			'approved_ru' => 1,
			'approved_en' => 1
		]);

		$this->get("/recipes/$recipe->id")
			->assertOk()
			->assertViewIs('recipes.show');
	}
}
