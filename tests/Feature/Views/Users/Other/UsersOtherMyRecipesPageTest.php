<?php

namespace Tests\Feature\Views\Users\Other;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UsersOtherMyRecipesPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * @return void
     */
    public function view_users_other_my_recipes_has_data(): void
    {
        $user = create(User::class);

        $recipe = create(Recipe::class, [
            'user_id' => $user->id,
            'title_' . lang() => 'Nice test',
        ]);

        $this->actingAs($user)
            ->get('/users/other/my-recipes')
            ->assertSeeText('Nice test')
            ->assertViewIs('users.other.my-recipes')
            ->assertViewHas('recipes', Recipe::whereUserId($user->id)->latest()->paginate(20));
    }

    /**
     * @test
     * @return void
     */
    public function guest_cant_see_my_recipes_page(): void
    {
        $this->get('/users/other/my-recipes')->assertRedirect('/login');
    }

    /**
     * @test
     * @return void
     */
    public function auth_user_can_see_my_recipes_page(): void
    {
        $this->actingAs(make(User::class))
            ->get('/users/other/my-recipes')
            ->assertOk();
    }
}
