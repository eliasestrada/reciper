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
}
