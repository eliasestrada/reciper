<?php

namespace Tests\Feature\Views\Pages;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SearchPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * resources/views/pages/search
     * @test
     * @return void
     */
    public function viewPagesSearchHasData(): void
    {
        $this->get('/search')
            ->assertViewIs('pages.search')
            ->assertViewHas('message');

        $this->get('/search?for=some')
            ->assertViewIs('pages.search')
            ->assertViewHasAll(['recipes', 'message']);
    }

    /**
     * resources/views/pages/search
     * @test
     * @return void
     */
    public function serchFormShowsResultsAfterSubmitting(): void
    {
        factory(Recipe::class)->create(['title_' . locale() => 'Recipe for test']);

        $this->get('/search?for=Recipe+for+test')
            ->assertOk()
            ->assertSeeText('Recipe for test');
    }

    /**
     * resources/views/pages/search
     * @test
     * @return void
     */
    public function guestCanSeeSearchPage(): void
    {
        $this->get('/search')->assertOk();
    }

    /**
     * resources/views/pages/search
     * @test
     * @return void
     */
    public function authUserCanSeeSearchPage(): void
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)->get('/search')->assertOk();
    }
}
