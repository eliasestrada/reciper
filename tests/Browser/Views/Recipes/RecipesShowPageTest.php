<?php

namespace Tests\Browser\Views\Recipes;

use App\Models\Recipe;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RecipesShowPageTest extends DuskTestCase
{
    /**
     * @test
     * @return void
     */
    public function guest_can_like_and_dislike_recipe(): void
    {
        $this->artisan('wipe');

        $this->browse(function (Browser $browser) {
            $recipe = create(Recipe::class);

            $browser
                ->visit("/recipes/$recipe->id")
                ->waitFor('.like-icon')
                ->assertSeeIn('#_all-likes', 0)
                ->click('.like-icon')
                ->assertSeeIn('#_all-likes', 1);
        });
    }
}
