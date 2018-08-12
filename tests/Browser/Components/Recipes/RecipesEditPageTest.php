<?php

namespace Tests\Browser\Components\Recipes;

use App\Models\Recipe;
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RecipesEditPageTest extends DuskTestCase
{
    /**
     * @test
     * @return void
     * */
    public function user_can_edit_his_own_recipe(): void
    {
        $this->artisan('wipe');

        $this->browse(function (Browser $browser) {
            $user = factory(User::class)->create();
            $recipe = factory(Recipe::class)->create([
                'user_id' => $user->id,
            ]);

            $browser
                ->loginAs($user)
                ->visit("/recipes/$recipe->id")
                ->click('#_more')
                ->click('#_edit')
                ->assertPathIs("/recipes/$recipe->id/edit")
                ->click('#_more')
                ->click('#publish-btn')
                ->assertPathIs("/users/$user->id")
                ->logout();
        });
    }

    /**
     * @test
     * @return void
     * */
    public function user_cant_edit_other_recipes(): void
    {
        $this->browse(function (Browser $browser) {
            $user = factory(User::class)->create();

            $recipe = factory(Recipe::class)->create([
                'user_id' => factory(User::class)->create()->id,
            ]);

            $browser
                ->loginAs($user)
                ->visit("/recipes/$recipe->id")
                ->assertDontSee('.edit-recipe-icon')
                ->visit("/recipes/$recipe->id/edit")
                ->assertPathIs('/recipes');
        });
    }
}
