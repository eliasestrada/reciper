<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RecipesDuskTest extends DuskTestCase
{
    /**
     * @author Cho
     * @test
     */
    public function user_can_like_and_dislike_recipe(): void
    {
        $this->browse(function ($user) {
            $user->loginAs(create_user())
                ->visit('/recipes/morkov-po-koreyski')
                ->waitFor('._like-button')
                ->assertSeeIn('._like-button span', 0)
                ->click('._like-button')
                ->waitFor('._like-button span')
                ->assertSeeIn('._like-button span', 1);
        });
    }

    /**
     * @author Cho
     * @test
     */
    public function user_can_add_recipe_to_favs(): void
    {
        $this->browse(function ($user) {
            $user->loginAs(create_user())
                ->visit('/recipes/morkov-po-koreyski')
                ->waitFor('._fav-button')
                ->assertSeeIn('._fav-button span', 0)
                ->click('._fav-button')
                ->waitFor('._fav-button span')
                ->assertSeeIn('._fav-button span', 1);
        });
    }

    /**
     * @author Cho
     * @test
     */
    public function user_can_open_recipe_menu_by_clicking_open_menu_button(): void
    {
        $this->browse(function ($browser) {
            $browser->visit('/recipes/morkov-po-koreyski')
                ->click('#popup-window-trigger')
                ->assertSee(trans('messages.print'));
        });
    }
}
