<?php

namespace Tests\Feature;

use App\Models\Fav;
use Tests\TestCase;
use App\Models\Like;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Popularity;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserPopularityTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var \App\Models\Popularity
     */
    private $popularity;

    /**
     * Setup the test environment
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->popularity = new Popularity;
    }

    /**
     * @test
     */
    public function user_gets_popularity_points_for_adding_his_recipe_to_favs(): void
    {
        $some_user = create_user();
        $author = create_user();
        $authors_recipe = create(Recipe::class, ['user_id' => $author->id]);
        $fav_point = config('custom.popularity_for_favs');

        $this->actingAs($some_user)->post(action('Api\FavController@store', [
            'id' => $authors_recipe->id,
        ]));
        $this->assertEquals($fav_point, User::whereId($author->id)->value('popularity'));
    }

    /**
     * @test
     */
    public function user_looses_popularity_points_for_removing_his_recipe_from_favs(): void
    {
        $some_user = create_user();
        $author = create_user('', ['popularity' => config('custom.popularity_for_favs')]);
        $authors_recipe = create(Recipe::class, ['user_id' => $author->id]);

        Fav::create(['user_id' => $some_user->id, 'recipe_id' => $authors_recipe->id]);

        $this->actingAs($some_user)->post(action('Api\FavController@store', [
            'id' => $authors_recipe->id,
        ]));
        $this->assertEquals(0, User::whereId($author->id)->value('popularity'));
    }

    /**
     * @test
     */
    public function user_gets_popularity_points_for_like(): void
    {
        $some_user = create_user();
        $author = create_user();
        $authors_recipe = create(Recipe::class, ['user_id' => $author->id]);
        $like_points = config('custom.popularity_for_like');

        $this->actingAs($some_user)->post(action('Api\LikeController@store', [
            'id' => $authors_recipe->id,
        ]));
        $this->assertEquals($like_points, User::whereId($author->id)->value('popularity'));
    }

    /**
     * @test
     */
    public function user_looses_popularity_points_for_dislike(): void
    {
        $some_user = create_user();
        $author = create_user('', ['popularity' => config('custom.popularity_for_like')]);
        $authors_recipe = create(Recipe::class, ['user_id' => $author->id]);

        Like::create(['user_id' => $some_user->id, 'recipe_id' => $authors_recipe->id]);

        $this->actingAs($some_user)->post(action('Api\LikeController@store', [
            'id' => $authors_recipe->id,
        ]));
        $this->assertEquals(0, User::whereId($author->id)->value('popularity'));
    }

    /**
     * @test
     */
    public function method_takeUser_returns_popularity_object(): void
    {
        $popularity = $this->popularity->takeUser(make(User::class));
        $this->assertInstanceOf(Popularity::class, $popularity);
    }

    /**
     * @test
     */
    public function method_takeUser_sets_user_as_property(): void
    {
        $user = make(User::class);
        $popularity = $this->popularity->takeUser($user);
        $this->assertEquals($user->toBase(), $popularity->user->toBase());
    }
}
