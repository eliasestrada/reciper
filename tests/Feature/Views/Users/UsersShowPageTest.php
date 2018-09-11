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
    public function view_users_show_has_data(): void
    {
        $user = create(User::class);
        $user->wasRecentlyCreated = false;
        $response = $this->actingAs($user)->get("/users/$user->id");

        $recipes = Recipe::whereUserId($user->id)
            ->withCount('likes')
            ->withCount('views')
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
            'user' => $user,
            'likes' => $likes,
            'views' => $views,
        ]);
    }

    /** @test */
    public function auth_user_can_see_users_show_page(): void
    {
        $user = make(User::class);
        $this->actingAs($user)->get('/users/' . $user->id)->assertOk();
    }

    /** @test */
    public function guest_can_see_users_show_page(): void
    {
        $user = make(User::class);
        $this->get("/users/$user->id")->assertOk();
    }
}
