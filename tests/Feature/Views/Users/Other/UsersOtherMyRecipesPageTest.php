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
        $this->actingAs(make(User::class))
            ->get('/users/other/my-recipes')
            ->assertOk()
            ->assertViewIs('users.other.my-recipes')
            ->assertViewHasAll(compact('recipes_ready', 'recipes_unready'));
    }

    /** @test */
    public function guest_cant_see_the_page(): void
    {
        $this->get('/users/other/my-recipes')->assertRedirect('/login');
    }

    /** @test */
    public function user_sees_his_recipe(): void
    {
        $user = create(User::class);
        $recipe = create(Recipe::class, ['user_id' => $user->id]);

        $this->actingAs($user)
            ->get('/users/other/my-recipes')
            ->assertSee("<section>{$recipe->getTitle()}</section>");
    }
}
