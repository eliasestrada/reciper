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
     * resources/views/users/show
     * @test
     * @return void
     */
    public function view_users_show_has_data(): void
    {
        $user = factory(User::class)->create();

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
            'user' => User::find($user->id),
            'likes' => $likes,
        ]);
    }

    /**
     * resources/view views/users/show
     * @test
     * @return void
     */
    public function auth_user_can_see_users_show_page(): void
    {
        $user = factory(User::class)->make();
        $this->actingAs($user)->get('/users/' . $user->id)->assertOk();
    }

    /**
     * resources/views/users/show
     * @test
     * @return void
     */
    public function guest_can_see_users_show_page(): void
    {
        $user = factory(User::class)->make();
        $this->get("/users/$user->id")->assertOk();
    }
}
