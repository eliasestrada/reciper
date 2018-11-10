<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LikeDuskTest extends DuskTestCase
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
}
