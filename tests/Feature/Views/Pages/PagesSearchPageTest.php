<?php

namespace Tests\Feature\Views\Pages;

use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PagesSearchPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @author Cho
     * @test
     */
    public function view_is_accessable(): void
    {
        $this->get('/search')
            ->assertOk()
            ->assertViewIs('pages.search');
    }

    /**
     * @author Cho
     * @test
     */
    public function serch_form_shows_results_after_submitting(): void
    {
        $recipe = create(Recipe::class, ['title_' . LANG() => 'Recipe for testing']);
        $this->get('/search?for=Recipe+for+testing')->assertSeeText('Recipe for testing');
    }

    /**
     * @author Cho
     * @test
     */
    public function when_nothing_found_message_appears(): void
    {
        $this->get('/search?for=nothing+cant+be+found')->assertSeeText(trans('pages.nothing_found'));

    }

    /**
     * @author Cho
     * @test
     */
    public function admin_can_search_for_user_by_id(): void
    {
        $this->actingAs($admin = create_user('admin'))
            ->get("/search?for=$admin->id")
            ->assertRedirect("/users/$admin->username");
    }

    /**
     * @author Cho
     * @test
     */
    public function user_cant_search_for_user_by_id(): void
    {
        $this->get('/search?for=' . create_user()->id)
            ->assertSeeText(trans('pages.nothing_found'));
    }
}
