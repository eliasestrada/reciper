<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserExpEventsTest extends TestCase
{
    use DatabaseTransactions;

    public $exp_for_approve;
    public $exp_for_like;
    public $exp_for_view;

    public function setUp()
    {
        parent::setUp();
        $this->exp_for_approve = config('custom.exp_for_approve');
        $this->exp_for_like = config('custom.exp_for_like');
        $this->exp_for_view = config('custom.exp_for_view');
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

        event(new \App\Events\RecipeGotLiked($recipe));
        $this->assertEquals($this->exp_for_like, User::whereId($user->id)->value('exp'));
    }

    /** @test */
    public function user_gets_exp_for_view(): void
    {
        $user = create_user('', ['exp' => 0]);
        $recipe = make(Recipe::class, ['user_id' => $user->id]);

        event(new \App\Events\RecipeGotViewed($recipe));
        $this->assertEquals($this->exp_for_view, User::whereId($user->id)->value('exp'));
    }
}
