<?php

namespace Tests\Feature\Views\Pages;

use Tests\TestCase;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PagesSearchPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function view_is_accessable(): void
    {
        $this->get('/search')
            ->assertOk()
            ->assertViewIs('pages.search');
    }

    /**
     * @test
     */
    public function search_form_shows_results_after_submitting(): void
    {
        $recipe = create(Recipe::class, [_('title') => 'Recipe for testing']);
        $this->get('/search?for=Recipe+for+testing')->assertSeeText('Recipe for testing');
    }

    /**
     * @test
     */
    public function when_nothing_found_message_appears(): void
    {
        $this->get('/search?for=nothing+cant+be+found')->assertSeeText(trans('pages.nothing_found'));

    }

    /**
     * @test
     */
    public function admin_can_search_for_user_by_id(): void
    {
        $this->actingAs($admin = create_user('admin'))
            ->get("/search?for={$admin->id}")
            ->assertRedirect("/users/{$admin->username}");
    }

    /**
     * @test
     */
    public function user_cant_search_for_user_by_id(): void
    {
        $this->get('/search?for=' . create_user()->id)
            ->assertSeeText(trans('pages.nothing_found'));
    }
}
