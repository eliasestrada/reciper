<?php

namespace Tests\Feature\Views\Pages;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SearchPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_has_data(): void
    {
        $this->get('/search')
            ->assertViewIs('pages.search')
            ->assertViewHasAll(['recipes', 'search_suggest', 'message']);

        $this->get('/search?for=some')
            ->assertViewIs('pages.search')
            ->assertViewHasAll(['recipes', 'search_suggest', 'message']);
    }

    /** @test */
    public function serch_form_shows_results_after_submitting(): void
    {
        create(Recipe::class, ['title_' . lang() => 'Recipe for test']);

        $this->get('/search?for=Recipe+for+test')
            ->assertOk()
            ->assertSeeText('Recipe for test');
    }

    /** @test */
    public function anyone_can_see_the_page(): void
    {
        $this->get('/search')->assertOk();
        $this->actingAs(create(User::class))
            ->get('/search')
            ->assertOk();
    }
}
