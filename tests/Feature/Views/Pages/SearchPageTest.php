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
    public function view_pages_search_has_data(): void
    {
        $this->get('/search')
            ->assertViewIs('pages.search')
            ->assertViewHasAll(['recipes', 'titles', 'images', 'message']);

        $this->get('/search?for=some')
            ->assertViewIs('pages.search')
            ->assertViewHasAll(['recipes', 'titles', 'images', 'message']);
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
    public function guest_can_see_search_page(): void
    {
        $this->get('/search')->assertOk();
    }

    /** @test */
    public function auth_user_can_see_search_page(): void
    {
        $this->actingAs(create(User::class))
            ->get('/search')
            ->assertOk();
    }
}
