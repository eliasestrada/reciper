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
        $recipe = create(Recipe::class, ['title_' . lang() => 'Recipe for test']);

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

    /** @test */
    public function admin_can_search_for_user_by_id(): void
    {
        $this->actingAs($admin = create_user('admin'))
            ->get("/search?for=$admin->id")
            ->assertRedirect("/users/$admin->id");
    }

    /** @test */
    public function user_cant_search_for_user_by_id(): void
    {
        $this->get('/search?for=' . create_user()->id)
            ->assertViewIs('pages.search')
            ->assertSeeText(trans('pages.nothing_found'));
    }
}
