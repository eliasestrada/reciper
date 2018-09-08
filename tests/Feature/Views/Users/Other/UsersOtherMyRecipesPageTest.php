<?php

namespace Tests\Feature\Views\Users\Other;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UsersOtherMyRecipesPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_users_other_my_recipes_has_data(): void
    {
        $user = create(User::class);

        create(Recipe::class, [
            'user_id' => $user->id,
            'title_' . lang() => 'My recipe',
        ]);

        $this->actingAs($user)
            ->get('/users/other/my-recipes')
            ->assertSeeText('My recipe')
            ->assertViewIs('users.other.my-recipes')
            ->assertViewHasAll([
                'recipes_ready' => $a = Recipe::whereUserId($user->id)
                    ->ready(1)
                    ->latest()
                    ->paginate(20)
                    ->onEachSide(1),
                'recipes_unready' => $b = Recipe::whereUserId($user->id)
                    ->ready(0)
                    ->latest()
                    ->paginate(20)
                    ->onEachSide(1),
            ]);
    }

    /** @test */
    public function guest_cant_see_my_recipes_page(): void
    {
        $this->get('/users/other/my-recipes')->assertRedirect('/login');
    }

    /** @test */
    public function auth_user_can_see_my_recipes_page(): void
    {
        $this->actingAs(make(User::class))
            ->get('/users/other/my-recipes')
            ->assertOk();
    }
}
