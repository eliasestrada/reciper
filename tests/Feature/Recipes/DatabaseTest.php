<?php

namespace Tests\Feature\Recipes;

use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DatabaseTest extends TestCase
{
	use DatabaseTransactions;

	/** @test*/
    public function checkIfRecipeCanBeCreatedInDatabase()
    {
		$recipe = factory(Recipe::class)->create(['title' => 'hello']);

		$this->assertDatabaseHas('recipes_' . locale(), [
			'title' => 'hello'
		]);		
	}
}
