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
     * Test for search page. View: resources/views/pages/search
     * @return void
     * @test
     */
    public function guestCanSeeSearchPage(): void
    {
        $this->get('/search')
            ->assertOk()
            ->assertViewIs('pages.search');
    }

    /**
     * Test for search page. View: resources/views/pages/search
     * @return void
     * @test
     */
    public function authUserCanSeeSearchPage(): void
    {
        $this->actingAs(factory(User::class)->create())
            ->get('/search')
            ->assertOk()
            ->assertViewIs('pages.search');
    }
}
