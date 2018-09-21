<?php

namespace Tests\Feature\Views\Users;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UsersShowPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_has_data(): void
    {
        $user = create_user();

        $response = $this->actingAs($user)->get("/users/$user->id");

        $recipes = Recipe::whereUserId($user->id)
            ->withCount('likes')
            ->withCount('views')
            ->done(1)
            ->latest()
            ->paginate(20)
            ->onEachSide(1);

        $likes = 0;
        $views = 0;

        foreach ($recipes as $recipe) {
            $likes += $recipe->likes_count;
            $views += $recipe->views_count;
        }

        $response->assertViewIs('users.show');
        $response->assertViewHasAll([
            'recipes' => $recipes,
            'user' => User::find($user->id),
            'likes' => $likes,
            'views' => $views,
        ]);
    }

    /** @test */
    public function auth_user_can_see_the_page(): void
    {
        $user = create_user();
        $this->actingAs($user)->get("/users/$user->id")->assertOk();
    }

    /** @test */
    public function guest_can_see_users_show_page(): void
    {
        $user = create_user();
        $this->get("/users/$user->id")->assertOk();
    }
}
