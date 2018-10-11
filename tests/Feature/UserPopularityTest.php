<?php

namespace Tests\Feature;

use App\Helpers\Popularity;
use App\Models\Fav;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserPopularityTest extends TestCase
{
    use DatabaseTransactions;

    private $popularity_for_like;
    private $popularity_for_view;
    private $popularity_for_favs;

    public function setUp()
    {
        parent::setUp();
        $this->popularity_for_like = config('custom.popularity_for_like');
        $this->popularity_for_view = config('custom.popularity_for_view');
        $this->popularity_for_favs = config('custom.popularity_for_favs');
    }

    /** @test */
    public function user_gets_popularity_points_for_like(): void
    {
        $user = create_user('', ['popularity' => 0]);
        $recipe = make(Recipe::class, ['user_id' => $user->id]);
        Popularity::add(config('custom.popularity_for_like'), $recipe->user_id);

        $this->assertEquals($this->popularity_for_like, User::whereId($user->id)->value('popularity'));
    }

    /** @test */
    public function user_looses_popularity_points_for_dislike(): void
    {
        $user = create_user('', ['popularity' => $this->popularity_for_like]);
        $recipe = make(Recipe::class, ['user_id' => $user->id]);
        Popularity::remove(config('custom.popularity_for_like'), $recipe->user_id);

        $this->assertEquals(0, User::whereId($user->id)->value('popularity'));
    }

    /** @test */
    public function user_gets_popularity_points_for_view(): void
    {
        $user = create_user('', ['popularity' => 0]);
        $recipe = make(Recipe::class, ['user_id' => $user->id]);
        // Fix this useless test
        Popularity::add(config('custom.popularity_for_view'), $recipe->user_id);
        $this->assertEquals($this->popularity_for_view, User::whereId($user->id)->value('popularity'));
    }

    /** @test */
    public function user_get_popularity_points_for_adding_his_recipe_to_favs(): void
    {
        $user = create_user();
        $author = create_user('', ['popularity' => 0]);
        $recipe = create(Recipe::class, ['user_id' => $author->id]);

        $this->actingAs($user)->post(action('FavsController@store', ['id' => $recipe->id]));
        $this->assertEquals($this->popularity_for_favs, User::whereId($author->id)->value('popularity'));
    }

    /** @test */
    public function user_looses_popularity_points_for_removing_his_recipe_from_favs(): void
    {
        $user = create_user();
        $author = create_user('', ['popularity' => $this->popularity_for_favs]);
        $recipe = create(Recipe::class, ['user_id' => $author->id]);
        Fav::create(['user_id' => $user->id, 'recipe_id' => $recipe->id]);

        $this->actingAs($user)->post(action('FavsController@store', ['id' => $recipe->id]));
        $this->assertEquals(0, User::whereId($author->id)->value('popularity'));
    }
}
