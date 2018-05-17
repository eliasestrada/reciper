<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Recipe;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RecipesTest extends DuskTestCase
{
	use DatabaseTransactions;

	/** @test */
    public function checkIfUserCanEditHisOwnRecipe()
    {
		$recipe = Recipe::where('user_id', 1)->first();

        $this->browse(function ($first) use ($recipe) {
			$first->loginAs(User::find(1))
				->visit('/recipes/' . $recipe->id)
				->click('.edit-recipe-icon')
				->assertPathIs('/recipes/'.$recipe->id.'/edit')
				->check('ready')
				->click('#submit-save-recipe')
				->assertSee('Рецепт опубликован')
				->assertPathIs('/recipes')
				->pause(1000);
        });
	}

	/** @test */
    public function checkIfUserCantEditOtherRecipes()
    {
		$recipe = Recipe::where('user_id', 1)->first();

        $this->browse(function ($first) use ($recipe) {
			$first->loginAs(User::find(2))
				->visit('/recipes/' . $recipe->id)
				->pause(1000)
				->assertDontSee('.edit-recipe-icon')
				->visit('/recipes/' . $recipe->id . '/edit')
				->assertSee('Вы не можете редактировать');
        });
    }
}
