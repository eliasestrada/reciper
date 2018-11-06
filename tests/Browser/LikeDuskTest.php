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
    public function guest_can_like_and_dislike_recipe(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/recipes/morkov-po-koreyski')
                ->waitFor('.like-icon')
                ->assertSeeIn('#_all-likes', 0)
                ->click('.like-icon')
                ->waitFor('#_all-likes')
                ->assertSeeIn('#_all-likes', 1);
        });
    }

    /**
     * @author Cho
     * @test
     */
    public function heart_icon_appears_on_navbar_after_giving_a_like_and_disappears_after_dislike(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/recipes/morkov-po-koreyski')
                ->waitFor('.like-icon')
                ->assertDontSeeIn('#visitor-likes-number', 1)
                ->press('.like-icon')
                ->press('#_hamb-menu')
                ->waitFor('#visitor-likes-number')
                ->assertSeeIn('#visitor-likes-number', 1)
                ->press('.like-icon')
                ->waitUntilMissing('#visitor-likes-number')
                ->assertDontSeeIn('#visitor-likes-number', 1);
        });
    }
}
