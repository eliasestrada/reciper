<?php

namespace Tests\Feature\Views\Users\Other;

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
    public function viewUsersOtherMyRecipesHasData(): void
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get('/users/other/my-recipes')
            ->assertViewIs('users.other.my-recipes')
            ->assertViewHas('recipes');
    }

    /**
     * @test
     * @return void
     */
    public function guestCantSeeMyRecipesPage(): void
    {
        $this->get('/users/other/my-recipes')->assertRedirect('/login');
    }

    /**
     * @test
     * @return void
     */
    public function authUserCanSeeMyRecipesPage(): void
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)->get('/users/other/my-recipes')->assertOk();
    }
}
