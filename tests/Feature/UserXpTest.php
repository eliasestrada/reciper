<?php

namespace Tests\Feature;

use App\Events\RecipeGotApproved;
use App\Models\Recipe;
use App\Models\User;
use Event;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserXpTest extends TestCase
{
    use DatabaseTransactions;

    private $xp_for_approve;
    private $max_xp;

    /**
     * @author Cho
     */
    public function setUp()
    {
        parent::setUp();
        $this->withoutNotifications();
        $this->xp_for_approve = config('custom.xp_for_approve');
        $this->max_xp = config('custom.max_xp');
    }

    /**
     * @author Cho
     * @test
     */
    public function user_gets_exp_for_approving_recipe(): void
    {
        $user = create_user('', ['xp' => 0]);
        $recipe = make(Recipe::class, ['user_id' => $user->id, _('published') => 0]);

        event(new RecipeGotApproved($recipe));
        $this->assertEquals($this->xp_for_approve, User::whereId($user->id)->value('xp'));
    }

    /**
     * @author Cho
     * @test
     */
    public function user_doesnt_get_exp_for_approving_recipe_if_it_was_approved_before(): void
    {
        $user = create_user('', ['xp' => 0]);
        $recipe = make(Recipe::class, ['user_id' => $user->id, _('published') => 1]);

        event(new RecipeGotApproved($recipe));
        $this->assertEquals(0, User::whereId($user->id)->value('xp'));
    }

    /**
     * @author Cho
     * @test
     */
    public function user_doesnt_get_exp_for_approving_recipe_if_he_has_maximum_xp(): void
    {
        $user = create_user('', ['xp' => $this->max_xp]);
        $recipe = make(Recipe::class, ['user_id' => $user->id, _('published') => 0]);

        event(new RecipeGotApproved($recipe));
        $this->assertEquals($this->max_xp, User::whereId($user->id)->value('xp'), 'Max xp doesnt equal user\'s xp');
    }

    /**
     * @author Cho
     * @test
     */
    public function user_gets_amount_of_points_that_left_if_he_has_almost_maximum_exp(): void
    {
        $user = create_user('', ['xp' => $this->max_xp - $this->xp_for_approve]);
        $recipe = make(Recipe::class, ['user_id' => $user->id, _('published') => 0]);

        event(new RecipeGotApproved($recipe));
        $this->assertEquals($this->max_xp, User::whereId($user->id)->value('xp'), 'Max xp doesnt equal user\'s xp');
    }

    /**
     * @author Cho
     * @test
     */
    public function reset_streak_days_if_user_visited_app_after_2_days(): void
    {
        $user = create_user('', ['streak_check' => now()->subDays(2), 'online_check' => now()->subHour()]);
        $this->actingAs($user)->get('/');
        $this->assertDatabaseHas('users', ['id' => $user->id, 'streak_days' => 0]);
    }

    /**
     * @author Cho
     * @test
     */
    public function user_got_strike_cookie_when_first_time_visits_app(): void
    {
        $user = create_user('', [
            'streak_days' => 1,
            'streak_check' => now()->subDay(),
            'online_check' => now()->subHour(),
        ]);
        $this->actingAs($user)->get('/')->assertCookie('r_ekirts');
    }

    /**
     * @author Cho
     * @test
     */
    public function update_streak_check_to_now_after_visiting_the_app(): void
    {
        $user = create_user('', ['streak_check' => $date = now()->subDay(), 'online_check' => now()->subHour()]);
        $this->actingAs($user)->get('/');

        $user_streak_date = User::whereId($user->id)->value('streak_check');
        $this->assertEquals(date('Y-m-d H:i'), date("Y-m-d H:i", strtotime($user_streak_date)));
    }

    /**
     * @author Cho
     * @test
     */
    public function streak_check_is_not_updated_when_already_visited_today_hour_ago(): void
    {
        $user = create_user('', ['streak_check' => $date = now()->subHour(), 'online_check' => now()->subHour()]);
        $this->actingAs($user)->get('/');
        $this->assertDatabaseHas('users', ['id' => $user->id, 'streak_check' => $date]);
    }

    /**
     * @author Cho
     * @test
     */
    public function streak_check_is_not_updated_when_already_visited_today_23_hours_ago(): void
    {
        $user = create_user('', ['streak_check' => $date = now()->subHours(23), 'online_check' => now()->subHour()]);
        $this->actingAs($user)->get('/');
        $this->assertDatabaseHas('users', ['id' => $user->id, 'streak_check' => $date]);
    }

    /**
     * @author Cho
     * @test
     */
    public function add_streak_day_if_user_visited_app_next_days(): void
    {
        $user = create_user('', ['streak_check' => now()->subDay(), 'online_check' => now()->subHour()]);
        $this->actingAs($user)->get('/');
        $this->assertDatabaseHas('users', ['id' => $user->id, 'streak_days' => 1]);
    }

    /**
     * @author Cho
     * @test
     */
    public function dont_add_streak_day_if_user_visited_app_in_hour(): void
    {
        $user = create_user('', ['streak_check' => now()->subHour(), 'online_check' => now()->subHour()]);
        $this->actingAs($user)->get('/');
        $this->assertDatabaseHas('users', ['id' => $user->id, 'streak_days' => 0]);
    }

    /**
     * @author Cho
     * @test
     */
    public function dont_add_streak_day_if_user_visited_app_in_23_hours(): void
    {
        $user = create_user('', ['streak_check' => now()->subHours(23), 'online_check' => now()->subHour()]);
        $this->actingAs($user)->get('/');
        $this->assertDatabaseHas('users', ['id' => $user->id, 'streak_days' => 0]);
    }

    /**
     * @author Cho
     * @test
     */
    public function add_xp_for_days_in_a_row(): void
    {
        $user = create_user('', [
            'streak_check' => now()->subDay(),
            'online_check' => now()->subHour(),
            'xp' => 0,
        ]);
        $this->actingAs($user)->get('/');
        $this->assertDatabaseHas('users', ['id' => $user->id, 'xp' => 1]);
    }

    /**
     * @author Cho
     * @test
     */
    public function dont_add_xp_if_user_visited_app_in_hour(): void
    {
        $user = create_user('', [
            'streak_check' => now()->subHour(),
            'online_check' => now()->subHour(),
            'xp' => 0,
        ]);
        $this->actingAs($user)->get('/');
        $this->assertDatabaseHas('users', ['id' => $user->id, 'xp' => 0]);
    }

    /**
     * @author Cho
     * @test
     */
    public function dont_add_xp_if_user_visited_app_in_23_hours(): void
    {
        $user = create_user('', [
            'streak_check' => now()->subHours(23),
            'online_check' => now()->subHour(),
            'xp' => 0,
        ]);
        $this->actingAs($user)->get('/');
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }
}
