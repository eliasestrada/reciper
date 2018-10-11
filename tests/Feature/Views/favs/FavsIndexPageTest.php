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
        $response = $this->actingAs($user)->get('/favs');

        $favs = Recipe::query()
            ->join('favs', 'favs.recipe_id', '=', 'recipes.id')
            ->selectBasic(['recipe_id'], ['id'])
            ->where('favs.user_id', $user->id)
            ->orderBy('favs.id', 'desc')
            ->done(1)
            ->paginate(20)
            ->onEachSide(1);

        $favs->map(function ($recipe) {
            $recipe->id = $recipe->recipe_id;
        });

        $response->assertOk()
            ->assertViewIs('favs.index')
            ->assertViewHas('favs', $favs);
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
}
