<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserExpTest extends TestCase
{
    use DatabaseTransactions;

    private $exp_for_approve;
    private $max_exp;

    public function setUp()
    {
        parent::setUp();
        $this->exp_for_approve = config('custom.exp_for_approve');
        $this->max_exp = config('custom.max_exp');
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
    public function user_doesnt_get_exp_for_approving_recipe_if_he_has_maximum(): void
    {
        // Has 100 exp
        $user = create_user('', ['exp' => $this->max_exp]);
        $recipe = make(Recipe::class, ['user_id' => $user->id]);

        event(new \App\Events\RecipeGotApproved($recipe, 'message'));
        $this->assertEquals($this->max_exp, User::whereId($user->id)->value('exp'));

        // Has 99 exp
        $user = create_user('', ['exp' => $this->max_exp - 0.8]);
        $recipe = make(Recipe::class, ['user_id' => $user->id]);

        event(new \App\Events\RecipeGotApproved($recipe, 'message'));
        $this->assertEquals($this->max_exp, User::whereId($user->id)->value('exp'));
    }

    /** @test */
    public function user_gets_amount_of_points_that_left_if_he_has_almost_maximum_exp(): void
    {
        $user = create_user('', ['exp' => $this->max_exp - $this->exp_for_approve]);
        $recipe = make(Recipe::class, ['user_id' => $user->id]);

        event(new \App\Events\RecipeGotApproved($recipe, 'message'));
        $this->assertEquals($this->max_exp, User::whereId($user->id)->value('exp'));
    }

    /** @test */
    public function user_looses_exp_for_drafting_recipe(): void
    {
        $user = create_user('', ['exp' => $this->exp_for_approve]);
        $recipe = make(Recipe::class, ['user_id' => $user->id]);

        event(new \App\Events\RecipeGotDrafted($recipe));
        $this->assertEquals(0, User::whereId($user->id)->value('exp'));
    }
}
