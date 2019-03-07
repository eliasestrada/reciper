<?php

namespace Tests\Browser;

use App\Models\Recipe;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RecipesDuskTest extends DuskTestCase
{
    /**
     * @test
     */
    public function user_can_like_and_dislike_recipe(): void
    {
        $this->browse(function ($user) {
            $recipe = create(Recipe::class);

            $user->loginAs(create_user())
                ->visit("/recipes/{$recipe->slug}")
                ->waitFor('._like-button')
                ->assertSeeIn('._like-button span', 0)
                ->click('._like-button')
                ->waitFor('._like-button span')
                ->assertSeeIn('._like-button span', 1);
        });
    }

    /**
     * @test
     */
    public function user_can_add_recipe_to_favs_on_show_page(): void
    {
        $this->browse(function ($user) {
            $recipe = create(Recipe::class);

            $user->loginAs(create_user())
                ->visit("/recipes/{$recipe->slug}")
                ->waitFor('._fav-button')
                ->assertSeeIn('._fav-button span', 0)
                ->click('._fav-button')
                ->waitFor('._fav-button span')
                ->assertSeeIn('._fav-button span', 1);
        });
    }

    /**
     * @test
     */
    public function user_can_add_recipe_to_favs_on_recipes_index_page(): void
    {
        $this->browse(function ($user) {
            $user->loginAs(create_user())
                ->visit('/recipes')
                ->waitFor('._fav-button:first-child')
                ->assertSeeIn('._fav-button:first-child span', 0)
                ->click('._fav-button:first-child')
                ->waitFor('._fav-button:first-child span')
                ->assertSeeIn('._fav-button:first-child span', 1);
        });
    }

    /**
     * @test
     */
    public function user_can_add_recipe_to_favs_on_pages_home_page(): void
    {
        $this->browse(function ($user) {
            $user->loginAs(create_user())
                ->visit('/')
                ->waitFor('._fav-button:first-child')
                ->assertSeeIn('._fav-button:first-child span', 0)
                ->click('._fav-button:first-child')
                ->waitFor('._fav-button:first-child span')
                ->assertSeeIn('._fav-button:first-child span', 1);
        });
    }

    /**
     * @test
     */
    public function user_can_remove_recipe_from_favs_on_favorites_index_page(): void
    {
        $this->browse(function ($user) {
            $auth = create_user();
            $auth->favs()->create(['recipe_id' => create(Recipe::class)->id]);

            $user->loginAs($auth)
                ->visit('/favs')
                ->waitFor('._fav-button')
                ->assertSeeIn('._fav-button span', 1)
                ->click('._fav-button')
                ->waitFor('._fav-button span')
                ->assertSeeIn('._fav-button span', 0);
        });
    }

    /**
     * @test
     */
    public function user_can_open_recipe_menu_by_clicking_open_menu_button(): void
    {
        $this->browse(function ($browser) {
            $browser->visit('/recipes/morkov-po-koreyski')
                ->click('#popup-window-trigger')
                ->assertSee(mb_strtoupper(trans('messages.print')));
        });
    }

    /**
     * @test
     */
    public function recipe_is_deleted_after_click_on_delete_recipe_button(): void
    {
        $this->browse(function ($person) {
            $user = create_user();
            $recipe = create(Recipe::class, [
                'user_id' => $user->id,
            ], null, 'draft');

            $person->loginAs($user)
                ->visit("/recipes/{$recipe->slug}/edit")
                ->waitFor('#_delete-recipe')
                ->click('#_delete-recipe')
                ->assertDialogOpened(trans('recipes.are_you_sure_to_delete'))
                ->acceptDialog()
                ->pause(500)
                ->assertPathIs('/users/other/my-recipes');
        });
    }
}
