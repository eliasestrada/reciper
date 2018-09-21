<?php

namespace Tests\Browser\Views\Recipes;

use App\Models\Recipe;
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RecipesShowPageTest extends DuskTestCase
{
    /** @test */
    public function guest_can_like_and_dislike_recipe(): void
    {
        $this->artisan('wipe');

        $this->browse(function (Browser $browser) {
            $recipe = create(Recipe::class);

            $browser->visit("/recipes/$recipe->id")
                ->waitFor('.like-icon')
                ->assertSeeIn('#_all-likes', 0)
                ->click('.like-icon')
                ->waitFor('#_all-likes')
                ->assertSeeIn('#_all-likes', 1);
        });
    }

    /** @test */
    public function user_can_delete_his_recipe(): void
    {
        $this->browse(function (Browser $borwser) {
            $user = create(User::class);
            $recipe = create(Recipe::class, ['user_id' => $user->id]);

            $borwser->loginAs($user)
                ->visit("/recipes/$recipe->id/edit")
                ->waitFor('#_delete-recipe')
                ->click('#_delete-recipe')
                ->assertDialogOpened(trans('recipes.are_you_sure_to_delete'))
                ->acceptDialog()
                ->waitForLocation('/users/other/my-recipes')
                ->assertPathIs('/users/other/my-recipes');
        });
    }
}
