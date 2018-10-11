<?php

namespace Tests\Feature\Views\Help;

use App\Models\Fav;
use App\Models\Help;
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
        $user = make(User::class);
        $this->actingAs($user)
            ->get('/favs')
            ->assertOk()
            ->assertViewIs('favs.index')
            ->assertViewHasAll(compact('recipes'));
    }

    /** @test */
    public function page_is_not_accessible_by_visitors(): void
    {
        $this->get('/favs')->assertRedirect('/login');
    }

    /** @test */
    public function user_sees_recipe_that_added_to_favs_and_dont_see_after_deletion(): void
    {
        $user = create_user();
        $recipe = create(Recipe::class);

        $fav = Fav::create(['user_id' => $user->id, 'recipe_id' => $recipe->id]);
        $this->actingAs($user)->get('/favs')->assertSee('<img src="' . asset('storage/small/images/' . $recipe->image));

        Fav::whereId($fav->id)->delete();
        $this->actingAs($user)->get('/favs')->assertDontSee('<img src="' . asset('storage/small/images/' . $recipe->image));
    }

    /** @test */
    public function user_doesnt_see_recipe_if_category_of_this_recipe_is_not_selected(): void
    {
        $user = create_user();
        $recipe = create(Recipe::class);
        $recipe->categories()->sync([2, 3]);
        Fav::create(['user_id' => $user->id, 'recipe_id' => $recipe->id]);

        $this->actingAs($user)->get('/favs/4')
            ->assertDontSee('<img src="' . asset('storage/small/images/' . $recipe->image));

        $this->actingAs($user)->get('/favs/3')
            ->assertSee('<img src="' . asset('storage/small/images/' . $recipe->image));
    }
}
