<?php

namespace Tests\Browser\Components;

use App\Models\User;
use App\Models\Recipe;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class RecipesTest extends DuskTestCase
{
	/** @test */
    public function checkIfUserCanEditHisOwnRecipe()
    {
		$recipe = factory(Recipe::class)->create(['user_id' => 10]);
		$user = factory(User::class)->create(['id' => 10]);

        $this->browse(function ($first) use ($recipe, $user) {
			$first
				->loginAs($user)
				->visit('/recipes/' . $recipe->id)
				->click('#_more')
				->click('#_edit')
				->assertPathIs('/recipes/'.$recipe->id.'/edit')
				->click('#_more')
				->click('#publish-btn')
				->assertPathIs('/users/' . $user->id);
        });
	}

	/** @test */
    public function checkIfUserCantEditOtherRecipes()
    {
		$recipe = factory(Recipe::class)->create(['user_id' => 10]);
		$user = factory(User::class)->create(['id' => 11]);

        $this->browse(function ($first) use ($recipe, $user) {
			$first
				->loginAs($user)
				->visit('/recipes/' . $recipe->id)
				->assertDontSee('.edit-recipe-icon')
				->visit('/recipes/' . $recipe->id . '/edit')
				->assertPathIs('/recipes');
        });
    }
}
