<?php

namespace Tests\Feature;

use App\Models\Fav;
use App\Models\Like;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserPopularityTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @author Cho
     * @test
     */
    public function user_gets_popularity_points_for_adding_his_recipe_to_favs(): void
    {
        $some_user = create_user();
        $author = create_user();
        $authors_recipe = create(Recipe::class, ['user_id' => $author->id]);
        $fav_point = config('custom.popularity_for_favs');

        $this->actingAs($some_user)->post(action('WebApi\FavController@store', [
            'id' => $authors_recipe->id,
        ]));
        $this->assertEquals($fav_point, User::whereId($author->id)->value('popularity'));
    }

    /**
     * @author Cho
     * @test
     */
    public function user_looses_popularity_points_for_removing_his_recipe_from_favs(): void
    {
        $some_user = create_user();
        $author = create_user('', ['popularity' => config('custom.popularity_for_favs')]);
        $authors_recipe = create(Recipe::class, ['user_id' => $author->id]);

        Fav::create(['user_id' => $some_user->id, 'recipe_id' => $authors_recipe->id]);

        $this->actingAs($some_user)->post(action('WebApi\FavController@store', [
            'id' => $authors_recipe->id,
        ]));
        $this->assertEquals(0, User::whereId($author->id)->value('popularity'));
    }

    /**
     * @author Cho
     * @test
     */
    public function user_gets_popularity_points_for_like(): void
    {
        $some_user = create_user();
        $author = create_user();
        $authors_recipe = create(Recipe::class, ['user_id' => $author->id]);
        $like_points = config('custom.popularity_for_like');

        $this->actingAs($some_user)->post(action('WebApi\LikeController@store', [
            'id' => $authors_recipe->id,
        ]));
        $this->assertEquals($like_points, User::whereId($author->id)->value('popularity'));
    }

    /**
     * @author Cho
     * @test
     */
    public function user_looses_popularity_points_for_dislike(): void
    {
        $some_user = create_user();
        $author = create_user('', ['popularity' => config('custom.popularity_for_like')]);
        $authors_recipe = create(Recipe::class, ['user_id' => $author->id]);

        Like::create(['user_id' => $some_user->id, 'recipe_id' => $authors_recipe->id]);

        $this->actingAs($some_user)->post(action('WebApi\LikeController@store', [
            'id' => $authors_recipe->id,
        ]));
        $this->assertEquals(0, User::whereId($author->id)->value('popularity'));
    }
}
