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
    public function view_has_data(): void
    {
        $user = create(User::class);

        create(Recipe::class, [
            'user_id' => $user->id,
            'title_' . lang() => 'My recipe',
        ]);

        $response = $this->actingAs($user)->get('/users/other/my-recipes');

        $recipes_ready = Recipe::whereUserId($user->id)
            ->selectBasic()
            ->done(1)
            ->latest()
            ->paginate(20)
            ->onEachSide(1);

        $recipes_unready = Recipe::whereUserId($user->id)
            ->selectBasic()
            ->approved(0)
            ->latest()
            ->paginate(20)
            ->onEachSide(1);

        $favs = Recipe::query()
            ->join('favs', 'favs.recipe_id', '=', 'recipes.id')
            ->selectBasic(['recipe_id'], ['id'])
            ->where('favs.user_id', $user->id)
            ->orderBy('favs.id', 'desc')
            ->paginate(20)
            ->onEachSide(1);

        $favs->map(function ($recipe) {
            $recipe->id = $recipe->recipe_id;
        });

        $response->assertSeeText('My recipe')
            ->assertViewIs('users.other.my-recipes')
            ->assertViewHasAll(compact('recipes_ready', 'recipes_unready', 'favs'));
    }

    /** @test */
    public function guest_cant_see_the_page(): void
    {
        $this->get('/users/other/my-recipes')->assertRedirect('/login');
    }

    /** @test */
    public function auth_user_can_see_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get('/users/other/my-recipes')
            ->assertOk();
    }
}
