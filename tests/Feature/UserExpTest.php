<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\User;
use Tests\TestCase;

class UserExpTest extends TestCase
{
    // use DatabaseTransactions;

    private $xp_for_approve;
    private $xp_for_online;
    private $max_xp;

    public function setUp()
    {
        parent::setUp();
        $this->xp_for_approve = config('custom.xp_for_approve');
        $this->xp_for_online = config('custom.xp_for_online');
        $this->max_xp = config('custom.max_xp');
    }

    /** @test */
    public function user_gets_exp_for_approving_recipe(): void
    {
        $user = create_user('', ['xp' => 0]);
        $recipe = make(Recipe::class, ['user_id' => $user->id]);

        event(new \App\Events\RecipeGotApproved($recipe, 'message'));
        $this->assertEquals($this->xp_for_approve, User::whereId($user->id)->value('xp'));
    }

    /** @test */
    public function user_doesnt_get_exp_for_approving_recipe_if_he_has_maximum(): void
    {
        // Has 100 xp
        $user = create_user('', ['xp' => $this->max_xp]);
        $recipe = make(Recipe::class, ['user_id' => $user->id]);

        event(new \App\Events\RecipeGotApproved($recipe, 'message'));
        $this->assertEquals($this->max_xp, User::whereId($user->id)->value('xp'));

        // Has 99 xp
        $user = create_user('', ['xp' => $this->max_xp - 0.8]);
        $recipe = make(Recipe::class, ['user_id' => $user->id]);

        event(new \App\Events\RecipeGotApproved($recipe, 'message'));
        $this->assertEquals($this->max_xp, User::whereId($user->id)->value('xp'));
    }

    /** @test */
    public function user_gets_amount_of_points_that_left_if_he_has_almost_maximum_exp(): void
    {
        $user = create_user('', ['xp' => $this->max_xp - $this->xp_for_approve]);
        $recipe = make(Recipe::class, ['user_id' => $user->id]);

        event(new \App\Events\RecipeGotApproved($recipe, 'message'));
        $this->assertEquals($this->max_xp, User::whereId($user->id)->value('xp'));
    }

    /** @test */
    public function user_looses_exp_for_drafting_recipe(): void
    {
        $user = create_user('', ['xp' => $this->xp_for_approve]);
        $recipe = make(Recipe::class, ['user_id' => $user->id]);

        event(new \App\Events\RecipeGotDrafted($recipe));
        $this->assertEquals(0, User::whereId($user->id)->value('xp'));
    }

    /** @test */
    // public function user_gets_exp_for_online(): void
    // {
    //     $user = create_user('', ['streak_check' => now()->subDay()]);

    //     $this->actingAs($user)->get('/');
    //     $this->assertDatabaseHas('users', [
    //         'id' => $user->id,
    //         'streak_days' => 1,
    //         'streak_check' => date('Y-m-d H:i:s'),
    //         'xp' => $user->xp + $this->xp_for_online,
    //     ]);
    // }

    /** @test */
    public function user_got_cookie_when_first_time_visits_app(): void
    {
        $user = create_user('', ['streak_days' => 1, 'streak_check' => now()->subDay()]);

        $this->actingAs($user)->get('/')->assertCookie('strk');
    }
}
