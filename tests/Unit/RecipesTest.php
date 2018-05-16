<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RecipesTest extends TestCase
{
	use DatabaseTransactions;

	/** @test*/
    public function checkIfRecipeCanBeCreatedInDatabase()
    {
		$recipe = factory(Recipe::class)->create(['title' => 'hello']);
		
		$this->assertDatabaseHas('recipes', [
			'title' => 'hello'
		]);		
	}
	
	/** @test */
	public function checkIfCannotEditSomeonesRecipe()
	{
		$recipe = factory(Recipe::class)->create(['title' => 'World']);
		$user = factory(User::class)->create(['admin' => 1]);
		
		$this->actingAs($user)
			->visit('/recipe/' . $recipe->id)
			->see($recipe->title);
	}
}
