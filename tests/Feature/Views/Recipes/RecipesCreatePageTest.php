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
	 * Test for create recipe page. View: resources/views/recipes/create
	 * @return void
	 * @test
	 */
	public function authUserCanSeeRecipesCreatePage() : void
    {
		$user = User::find(factory(User::class)->create()->id);
	
		$this->actingAs($user)
			->get('/recipes/create')
			->assertOk()
			->assertViewIs('recipes.create');
	}
}
