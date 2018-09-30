<?php

namespace Tests\Feature\Views\Pages;

use App\Models\Recipe;
use App\Models\Title;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_has_data(): void
    {
        $responce = $this->get('/');

        $title_intro = Title::whereName("intro")->first([
            'title_' . lang(),
            'text_' . lang(),
        ]);

        $last_liked = Recipe::query()->join('likes', 'likes.recipe_id', '=', 'recipes.id')
            ->orderBy('likes.id', 'desc')
            ->limit(4)
            ->done(1)
            ->get(['recipe_id', 'image', 'intro_' . lang(), 'title_' . lang()]);

        $responce->assertViewIs('pages.home')
            ->assertViewHas('random_recipes')
            ->assertViewHas('last_liked', $last_liked);
    }

    /** @test */
    public function auth_user_can_see_the_page(): void
    {
        $user = make(User::class);
        $this->actingAs($user)->get('/')->assertOk();
    }

    /** @test */
    public function guest_can_see_the_page(): void
    {
        $this->get('/')->assertOk();
    }
}
