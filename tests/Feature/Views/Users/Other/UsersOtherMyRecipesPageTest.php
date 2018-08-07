<?php

namespace Tests\Feature\Views\Users\Other;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UsersOtherMyRecipesPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * resources/views/users/other/my-recipes
     * @test
     * @return void
     */
    public function view_users_other_my_recipes_has_data(): void
    {
        $user = factory(User::class)->make();

        $this->actingAs($user)
            ->get('/users/other/my-recipes')
            ->assertViewIs('users.other.my-recipes')
            ->assertViewHas('recipes');
    }

    /**
     * resources/views/users/other/my-recipes
     * @test
     * @return void
     */
    public function guest_cant_see_my_recipes_page(): void
    {
        $this->get('/users/other/my-recipes')->assertRedirect('/login');
    }

    /**
     * resources/views/users/other/my-recipes
     * @test
     * @return void
     */
    public function auth_user_can_see_my_recipes_page(): void
    {
        $user = factory(User::class)->make();
        $this->actingAs($user)->get('/users/other/my-recipes')->assertOk();
    }
}
