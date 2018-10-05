<?php

namespace Tests\Feature;

use App\Models\Fav;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserExpTest extends TestCase
{
    use DatabaseTransactions;

    private $exp_for_approve;
    private $exp_for_like;
    private $exp_for_view;
    private $exp_for_favs;

    public function setUp()
    {
        parent::setUp();
        $this->exp_for_approve = config('custom.exp_for_approve');
        $this->exp_for_like = config('custom.exp_for_like');
        $this->exp_for_view = config('custom.exp_for_view');
        $this->exp_for_favs = config('custom.exp_for_favs');
    }

    /** @test */
    public function user_gets_exp_for_approving_recipe(): void
    {
        $user = create_user('', ['exp' => 0]);
        $recipe = make(Recipe::class, ['user_id' => $user->id]);

        event(new \App\Events\RecipeGotApproved($recipe, 'message'));
        $this->assertEquals($this->exp_for_approve, User::whereId($user->id)->value('exp'));
    }

    /** @test */
    public function user_looses_exp_for_drafting_recipe(): void
    {
        $user = create_user('', ['exp' => $this->exp_for_approve]);
        $recipe = make(Recipe::class, ['user_id' => $user->id]);

        event(new \App\Events\RecipeGotDrafted($recipe));
        $this->assertEquals(0, User::whereId($user->id)->value('exp'));
    }

    /** @test */
    public function user_gets_exp_for_like(): void
    {
        $user = create_user('', ['exp' => 0]);
        $recipe = make(Recipe::class, ['user_id' => $user->id]);
        User::addExp(config('custom.exp_for_like'), $recipe->user_id);

        $this->assertEquals($this->exp_for_like, User::whereId($user->id)->value('exp'));
    }

    /** @test */
    public function user_looses_exp_for_dislike(): void
    {
        $user = create_user('', ['exp' => $this->exp_for_like]);
        $recipe = make(Recipe::class, ['user_id' => $user->id]);
        User::removeExp(config('custom.exp_for_like'), $recipe->user_id);

        $this->assertEquals(0, User::whereId($user->id)->value('exp'));
    }

    /** @test */
    public function user_gets_exp_for_view(): void
    {
        $user = create_user('', ['exp' => 0]);
        $recipe = make(Recipe::class, ['user_id' => $user->id]);

        event(new \App\Events\RecipeGotViewed($recipe));
        $this->assertEquals($this->exp_for_view, User::whereId($user->id)->value('exp'));
    }

    /** @test */
    public function user_get_exp_for_adding_his_recipe_to_favs(): void
    {
        $user = create_user();
        $author = create_user('', ['exp' => 0]);
        $recipe = create(Recipe::class, ['user_id' => $author->id]);

        $this->actingAs($user)->post(action('ApiFavsController@store', ['id' => $recipe->id]));
        $this->assertEquals($this->exp_for_favs, User::whereId($author->id)->value('exp'));
    }

    /** @test */
    public function user_looses_exp_for_removing_his_recipe_from_favs(): void
    {
        $user = create_user();
        $author = create_user('', ['exp' => $this->exp_for_favs]);
        $recipe = create(Recipe::class, ['user_id' => $author->id]);
        Fav::create(['user_id' => $user->id, 'recipe_id' => $recipe->id]);

        $this->actingAs($user)->post(action('ApiFavsController@store', ['id' => $recipe->id]));
        $this->assertEquals(0, User::whereId($author->id)->value('exp'));
    }
}
