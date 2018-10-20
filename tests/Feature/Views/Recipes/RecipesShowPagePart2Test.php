<?php

namespace Tests\Feature\Views\Recipes;

use App\Models\Fav;
use App\Models\Recipe;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RecipesShowPagePart2Test extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function owner_of_the_recipe_sees_report_button_disabled(): void
    {
        $user = create_user();
        $recipe = create(Recipe::class, ['user_id' => $user->id]);

        $this->actingAs($user)
            ->get("/recipes/$recipe->id")
            ->assertSee('<a href="#report-recipe-modal" class="btn waves-effect waves-light modal-trigger min-w" disabled>');
    }

    /** @test */
    public function auth_user_can_add_recipe_to_favs(): void
    {
        $user = create_user();
        $recipe = create(Recipe::class);

        $this->actingAs($user)
            ->post(action('FavsController@store', ['id' => $recipe->id]))
            ->assertOk()
            ->assertSeeText('active');

        $this->assertDatabaseHas('favs', [
            'recipe_id' => $recipe->id,
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function auth_user_can_delete_recipe_from_favs(): void
    {
        $user = create_user();
        $recipe = create(Recipe::class);
        Fav::create(['user_id' => $user->id, 'recipe_id' => $recipe->id]);

        $this->actingAs($user)
            ->post(action('FavsController@store', ['id' => $recipe->id]))
            ->assertOk()
            ->assertDontSeeText('active');

        $this->assertDatabaseMissing('favs', [
            'recipe_id' => $recipe->id,
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function visitor_can_like_the_recipe(): void
    {
        $visitor = create(Visitor::class);
        $recipe = create(Recipe::class);

        $this->post("/api/like/like/$recipe->id")
            ->assertExactJson(['liked' => 1]);
    }

    /** @test */
    public function visitor_can_dislike_the_recipe(): void
    {
        $visitor = create(Visitor::class);
        $recipe = create(Recipe::class);

        $this->post("/api/like/dislike/$recipe->id")
            ->assertExactJson(['liked' => 0]);
    }
}
