<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Recipe;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Support\Facades\Artisan;

class RecipesTest extends DuskTestCase
{
	/** @test */
    public function checkIfUserCanEditHisOwnRecipe()
    {
		Artisan::call('migrate:fresh');
		Artisan::call('db:seed');

		$recipe = Recipe::where('user_id', 1)->first();

        $this->browse(function ($first) use ($recipe) {
			$first
				->loginAs(User::find(1))
				->visit('/recipes/' . $recipe->id)
				->click('.btn-floating .main .btn-large .pulse .z-depth-3')
				->click('.btn-floating .btn-large .green .d-flex .tooltipped')
				->assertPathIs('/recipes/'.$recipe->id.'/edit')
				->click('.btn-floating .main .btn-large .pulse .z-depth-3')
				->click('.btn-floating .green .btn-large .tooltipped')
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
			$first
				->loginAs(User::find(2))
				->visit('/recipes/' . $recipe->id)
				->pause(1000)
				->assertDontSee('.edit-recipe-icon')
				->visit('/recipes/' . $recipe->id . '/edit')
				->assertSee('Вы не можете редактировать');
        });
    }
}
