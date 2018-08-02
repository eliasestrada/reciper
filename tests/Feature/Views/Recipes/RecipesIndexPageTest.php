<?php

namespace Tests\Feature\Views\Recipes;

use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RecipesIndexPageTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test for recipes page. View: resources/views/recipes/index
	 * @return void
	 * @test
	 */
	public function authUserCanSeeRecipesIndexPage() : void
    {
		$user = User::find(factory(User::class)->create()->id);

		$this->actingAs($user)
			->get("/recipes")
			->assertOk()
			->assertViewIs('recipes.index');
	}

	/**
	 * Test for recipes page. View: resources/views/recipes/index
	 * @return void
	 * @test
	 */
    public function guestCanSeeRecipesIndexPage() : void
    {
		$this->get('/recipes')
        	->assertOk()
        	->assertViewIs('recipes.index');
	}
}
