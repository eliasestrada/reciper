<?php

namespace Tests\Feature\Guest\Pages\CanSee;

use Tests\TestCase;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GuestCanSeeRecipesTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test for recipes page. View: resources/views/recipes/index
	 * @return void
	 * @test
	 */
    public function guestCanSeeRecipesPage() : void
    {
		$this->get('/recipes')
        	->assertSuccessful()
        	->assertViewIs('recipes.index');
	}

	/**
	 * Test for show recipe page. View: resources/views/recipes/show
	 * @return void
	 * @test
	 */
	public function guestCanSeeShowPage() : void
    {
		$recipe = factory(Recipe::class)->create([
			'ready_ru' => 1,
			'ready_en' => 1,
			'approved_ru' => 1,
			'approved_en' => 1
		]);

		$this->get("/recipes/$recipe->id")
			->assertSuccessful()
			->assertViewIs('recipes.show');
	}
}
