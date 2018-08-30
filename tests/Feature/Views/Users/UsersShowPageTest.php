<?php

namespace Tests\Feature\Views\Users;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UsersShowPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * @return void
     */
    public function view_users_show_has_data(): void
    {
        $user = create(User::class);
        $user->wasRecentlyCreated = false;

        $response = $this->actingAs($user)->get("/users/$user->id");

        $recipes = Recipe::whereUserId($user->id)
            ->withCount('likes')
            ->latest()
            ->paginate(20);

        $likes = 0;

        foreach ($recipes as $recipe) {
            $likes += $recipe->likes_count;
        }

        $response->assertViewIs('users.show');
        $response->assertViewHasAll([
            'recipes' => $recipes,
            'user' => $user,
            'likes' => $likes,
        ]);
    }

    /**
     * @test
     * @return void
     */
    public function auth_user_can_see_users_show_page(): void
    {
        $user = make(User::class);
        $this->actingAs($user)->get('/users/' . $user->id)->assertOk();
    }

    /**
     * @test
     * @return void
     */
    public function guest_can_see_users_show_page(): void
    {
        $user = make(User::class);
        $this->get("/users/$user->id")->assertOk();
    }
}
