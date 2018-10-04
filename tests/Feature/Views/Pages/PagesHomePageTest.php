<?php

namespace Tests\Feature\Views\Pages;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PagesHomePageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_has_data(): void
    {
        $responce = $this->get('/');

        $last_liked = Recipe::query()
            ->join('likes', 'likes.recipe_id', '=', 'recipes.id')
            ->orderBy('likes.id', 'desc')
            ->selectBasic(['recipe_id'], ['id'])
            ->limit(8)
            ->done(1)
            ->get(['recipe_id', 'image', 'intro_' . lang(), 'title_' . lang()]);

        $last_liked->map(function ($liked) {
            $liked->id = $liked->recipe_id;
        });

        $responce->assertViewIs('pages.home')
            ->assertViewHas('random_recipes')
            ->assertViewHasAll(['last_liked' => $last_liked]);
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
