<?php

namespace Tests\Feature\Views\Recipes;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RecipesIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_is_correct(): void
    {
        $this->get('/recipes')->assertViewIs('recipes.index');
    }

    /** @test */
    public function auth_user_can_see_the_page(): void
    {
        $user = make(User::class);
        $this->actingAs($user)->get("/recipes")->assertOk();
    }

    /** @test */
    public function guest_can_see_the_page(): void
    {
        $this->get('/recipes')->assertOk();
    }
}
