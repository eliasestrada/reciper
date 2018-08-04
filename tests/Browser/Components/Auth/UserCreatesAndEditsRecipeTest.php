<?php

namespace Tests\Browser\Components\Auth;

use App\Models\Recipe;
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserCreatesAndEditsRecipeTest extends DuskTestCase
{
    /**
     * @test
     * @return void
     * */
    public function checkIfUserCanEditHisOwnRecipe(): void
    {
        $recipe = factory(Recipe::class)->create(['user_id' => 10]);
        $user = factory(User::class)->create(['id' => 10]);

        $this->browse(function ($first) use ($recipe, $user) {
            $first
                ->loginAs($user)
                ->visit('/recipes/' . $recipe->id)
                ->click('#_more')
                ->click('#_edit')
                ->assertPathIs('/recipes/' . $recipe->id . '/edit')
                ->click('#_more')
                ->click('#publish-btn')
                ->assertPathIs('/users/' . $user->id);
        });
    }

    /**
     * @test
     * @return void
     * */
    public function checkIfUserCantEditOtherRecipes(): void
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

        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }
}
