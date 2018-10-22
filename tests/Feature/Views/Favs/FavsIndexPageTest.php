<?php

namespace Tests\Feature\Views\Favs;

use App\Models\Fav;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FavsIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function page_accessible_and_has_data(): void
    {
        $this->actingAs(make(User::class))
            ->get('/favs')
            ->assertOk()
            ->assertViewIs('favs.index')
            ->assertViewHas('recipes');
    }

    /** @test */
    public function page_is_not_accessible_by_visitors(): void
    {
        $this->get('/favs')->assertRedirect('/login');
    }

    /** @test */
    public function user_sees_recipe_that_added_to_favs(): void
    {
        $user = create_user();
        $recipe = create(Recipe::class);
        Fav::create(['user_id' => $user->id, 'recipe_id' => $recipe->id]);

        $this->actingAs($user)
            ->get('/favs')
            ->assertSee('<img src="' . asset('storage/small/recipes/' . $recipe->image));
    }

    /** @test */
    public function user_dont_see_recipe_after_its_deleted(): void
    {
        Fav::create([
            'user_id' => ($user = create_user())->id,
            'recipe_id' => ($recipe = create(Recipe::class))->id,
        ]);

        $user->favs()->whereRecipeId($recipe->id)->delete();

        $this->actingAs($user)
            ->get('/favs')
            ->assertDontSee('<img src="' . asset('storage/small/recipes/' . $recipe->image));
    }

    /** @test */
    public function user_can_delete_recipe_from_favs(): void
    {
        Fav::create([
            'user_id' => ($user = create_user())->id,
            'recipe_id' => ($recipe = create(Recipe::class))->id,
        ]);
        $this->actingAs($user)->post("/favs/$recipe->id")->assertOk();
    }

    /** @test */
    public function user_doesnt_see_recipe_if_category_of_this_recipe_is_not_selected(): void
    {
        ($recipe = create(Recipe::class))->categories()->sync([2, 3]);
        Fav::create([
            'user_id' => ($user = create_user())->id,
            'recipe_id' => $recipe->id,
        ]);

        $this->actingAs($user)
            ->get('/favs/4')
            ->assertDontSee('<img src="' . asset('storage/small/recipes/' . $recipe->image));
    }

    /** @test */
    public function user_sees_recipe_if_category_of_this_recipe_is_selected(): void
    {
        ($recipe = create(Recipe::class))->categories()->sync([2, 3]);
        Fav::create([
            'user_id' => ($user = create_user())->id,
            'recipe_id' => $recipe->id,
        ]);

        $this->actingAs($user)->get('/favs/3')
            ->assertSee('<img src="' . asset('storage/small/recipes/' . $recipe->image));
    }
}
