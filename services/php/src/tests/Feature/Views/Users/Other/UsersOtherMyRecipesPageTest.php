<?php

namespace Tests\Feature\Views\Users\Other;

use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersOtherMyRecipesPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function user_can_see_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get('/users/other/my-recipes')
            ->assertOk()
            ->assertViewIs('users.other.my-recipes');
    }

    /**
     * @test
     */
    public function guest_cant_see_the_page(): void
    {
        $this->get('/users/other/my-recipes')->assertRedirect();
    }

    /**
     * @test
     */
    public function user_sees_his_recipe(): void
    {
        $user = create(User::class);
        $recipe = create(Recipe::class, ['user_id' => $user->id]);

        $this->actingAs($user)
            ->get('/users/other/my-recipes')
            ->assertSee("<section>{$recipe->getTitle()}</section>");
    }
}
