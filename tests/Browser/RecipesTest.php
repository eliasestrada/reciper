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
        $this->browse(function ($first) {
			$first->loginAs(User::find(1))
				->visit('/recipes/1')
				->assertSee('hello');
        });
    }
}
