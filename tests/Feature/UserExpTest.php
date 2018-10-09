<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserExpTest extends TestCase
{
    use DatabaseTransactions;

    private $xp_for_approve;
    private $max_xp;

    public function setUp()
    {
        parent::setUp();
        $this->xp_for_approve = config('custom.xp_for_approve');
        $this->max_xp = config('custom.max_xp');
    }

    /** @test */
    public function user_gets_exp_for_approving_recipe(): void
    {
        $user = create_user('', ['xp' => 0]);
        $recipe = make(Recipe::class, ['user_id' => $user->id, 'published_' . lang() => 0]);

        event(new \App\Events\RecipeGotApproved($recipe, 'message'));
        $this->assertEquals($this->xp_for_approve, User::whereId($user->id)->value('xp'));
    }

    /** @test */
    public function user_doesnt_gets_exp_for_approving_recipe_if_it_was_approved_before(): void
    {
        $user = create_user('', ['xp' => 0]);
        $recipe = make(Recipe::class, ['user_id' => $user->id, 'published_' . lang() => 1]);

        event(new \App\Events\RecipeGotApproved($recipe, 'message'));
        $this->assertEquals(0, User::whereId($user->id)->value('xp'));
    }

    /** @test */
    public function user_doesnt_get_exp_for_approving_recipe_if_he_has_maximum(): void
    {
        // Has 100 xp
        $user = create_user('', ['xp' => $this->max_xp]);
        $recipe = make(Recipe::class, ['user_id' => $user->id, 'published_ru' . lang() => 0]);

        event(new \App\Events\RecipeGotApproved($recipe, 'message'));
        $this->assertEquals($this->max_xp, User::whereId($user->id)->value('xp'));

        // Has 99 xp
        $user = create_user('', ['xp' => $this->max_xp - 0.8]);
        $recipe = make(Recipe::class, ['user_id' => $user->id, 'published_' . lang() => 0]);

        event(new \App\Events\RecipeGotApproved($recipe, 'message'));
        $this->assertEquals($this->max_xp, User::whereId($user->id)->value('xp'));
    }

    /** @test */
    public function user_gets_amount_of_points_that_left_if_he_has_almost_maximum_exp(): void
    {
        $user = create_user('', ['xp' => $this->max_xp - $this->xp_for_approve]);
        $recipe = make(Recipe::class, ['user_id' => $user->id, 'published_' . lang() => 0]);

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
    public function reset_streak_day_if_user_visited_app_after_2_days(): void
    {
        $user = create_user('', ['streak_check' => now()->subDays(2), 'updated_at' => now()->subHour()]);
        $this->actingAs($user)->get('/');
        $this->assertDatabaseHas('users', ['id' => $user->id, 'streak_days' => 0]);
    }

    /** @test */
    public function user_got_cookie_when_first_time_visits_app(): void
    {
        $user = create_user('', [
            'streak_days' => 1,
            'streak_check' => now()->subDay(),
            'updated_at' => now()->subHour(),
        ]);
        $this->actingAs($user)->get('/')->assertCookie('strk');
    }

    /** @test */
    public function update_streak_check_to_now_after_visiting_the_app(): void
    {
        $user = create_user('', ['streak_check' => $date = now()->subDay(), 'updated_at' => now()->subHour()]);
        $this->actingAs($user)->get('/');
        $this->assertDatabaseHas('users', ['id' => $user->id, 'streak_check' => date('Y-m-d H:i:s')]);
    }

    /** @test */
    public function streak_check_is_not_updated_when_already_visited_today(): void
    {
        $user = create_user('', ['streak_check' => $date = now()->subHour(), 'updated_at' => now()->subHour()]);
        $this->actingAs($user)->get('/');
        $this->assertDatabaseHas('users', ['id' => $user->id, 'streak_check' => $date]);

        $user->update(['streak_check' => $date = now()->subHours(23)]);
        $this->actingAs($user)->get('/');
        $this->assertDatabaseHas('users', ['id' => $user->id, 'streak_check' => $date]);
    }

    /** @test */
    public function add_streak_day_if_user_visited_app_next_days(): void
    {
        $user = create_user('', ['streak_check' => now()->subDay(), 'updated_at' => now()->subHour()]);
        $this->actingAs($user)->get('/');
        $this->assertDatabaseHas('users', ['id' => $user->id, 'streak_days' => 1]);
    }

    /** @test */
    public function dont_add_streak_day_if_user_visited_app_in_hour_or_23_hours(): void
    {
        $user = create_user('', ['streak_check' => now()->subHour(), 'updated_at' => now()->subHour()]);
        $this->actingAs($user)->get('/');
        $this->assertDatabaseHas('users', ['id' => $user->id, 'streak_days' => 0]);

        $user->update(['streak_check' => $date = now()->subHours(23)]);
        $this->actingAs($user)->get('/');
        $this->assertDatabaseHas('users', ['id' => $user->id, 'streak_days' => 0]);
    }

    /** @test */
    public function add_xp_for_days_in_a_row(): void
    {
        $user = create_user('', [
            'streak_check' => now()->subDay(),
            'updated_at' => now()->subHour(),
            'xp' => 0,
        ]);
        $this->actingAs($user)->get('/');
        $this->assertDatabaseHas('users', ['id' => $user->id, 'xp' => 1]);
    }

    /** @test */
    public function dont_add_xp_if_user_visited_app_in_hour_or_23_hours(): void
    {
        $user = create_user('', [
            'streak_check' => now()->subHour(),
            'updated_at' => now()->subHour(),
            'xp' => 0,
        ]);
        $this->actingAs($user)->get('/');
        $this->assertDatabaseHas('users', ['id' => $user->id, 'xp' => 0]);

        $user->update(['streak_check' => $date = now()->subHours(23)]);
        $this->actingAs($user)->get('/');
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }
}
