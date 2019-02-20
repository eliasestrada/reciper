<?php

namespace Tests\Feature\Helpers;

use App\Models\Xp;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class XpTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @author Cho
     * @test
     */
    public function xp_helper_has_attributes(): void
    {
        $this->assertClassHasAttribute('user', Xp::class);
        $this->assertClassHasAttribute('levels', Xp::class);
    }

    /**
     * Loop through all levels and assert that user's xp points matches level
     *
     * @author Cho
     * @test
     */
    public function getLevel_method_returns_current_users_level_depending_on_users_current_xp(): void
    {
        $xp = new Xp(make(User::class));

        foreach ($xp->levels as $level => $values) {
            $xp->user->xp = rand($values['min'], $values['max']);
            $this->assertEquals($level, $xp->getLevel());
        }
    }

    /**
     * @author Cho
     * @test
     */
    public function minXpForCurrentLevel_method_returns_minimum_value_of_xp_for_current_users_level(): void
    {
        $xp = new Xp(make(User::class));

        foreach ($xp->levels as $level) {
            $xp->user->xp = rand($level['min'], $level['max']);
            $this->assertEquals($level['min'], $xp->minXpForCurrentLevel());
        }
    }

    /**
     * @author Cho
     * @test
     */
    public function maxXpForCurrentLevel_method_returns_maximum_value_of_xp_for_current_users_level(): void
    {
        $xp = new Xp(make(User::class));

        foreach ($xp->levels as $level) {
            $xp->user->xp = rand($level['min'], $level['max']);
            $this->assertEquals($level['max'], $xp->maxXpForCurrentLevel());
        }
    }

    /**
     * @author Cho
     * @test
     */
    public function getPercent_method_always_returns_100_percent_on_each_level_if_user_has_maximum_xp(): void
    {
        $current_xp = new Xp(make(User::class));

        foreach ($current_xp->levels as $values) {
            $current_xp->user->xp = $values['max'];
            $this->assertEquals(100, $current_xp->getPercent());
        }
    }

    /**
     * when user has maximum level, getPercent will return 100, that's why
     * I use condition in loop, check if current level is the last, if yes
     * then expected value should be not 0 but 100
     * @author Cho
     * @test
     */
    public function getPercent_method_always_returns_0_percent_on_each_level_if_user_has_minimum_xp(): void
    {
        $current_xp = new Xp(make(User::class));
        $last_level = 10;

        foreach ($current_xp->levels as $level => $values) {
            $expected_percent = $level === $last_level ? 100 : 0;
            $current_xp->user->xp = $values['min'];
            $this->assertEquals($expected_percent, $current_xp->getPercent());
        }
    }

    /**
     * @author Cho
     * @test
     */
    public function add_method_adds_xp_and_returns_true_if_added_successfuly(): void
    {
        $user = create_user('', ['xp' => 0]);
        $response = (new Xp($user))->add(32.0);
        $this->assertTrue((bool) $response);
    }

    /**
     * @author Cho
     * @dataProvider addForStreakDays_method_adds_2_xp_points_for_2_days_in_a_row_provider
     * @test
     */
    public function addForStreakDays_method_adds_2_xp_points_for_2_days_in_a_row($streak_days): void
    {
        $user = create_user('', ['streak_days' => $streak_days, 'xp' => 0]);
        (new Xp($user))->addForStreakDays();
        $this->assertEquals($streak_days, $user->xp);
    }

    /**
     * Data provider for addForStreakDays_method_adds_2_xp_points_for_2_days_in_a_row test
     *
     * @return array
     */
    public function addForStreakDays_method_adds_2_xp_points_for_2_days_in_a_row_provider(): array
    {
        return [[2], [5], [10], [15], [20], [25], [30]];
    }

    /**
     * 30 xp is maximum xp user can get
     *
     * @author Cho
     * @test
     */
    public function addForStreakDays_method_adds_30_xp_points_for_31_days_in_a_row(): void
    {
        $expect_xp = 30;
        $days_in_a_row = 31;

        $user = create_user('', ['streak_days' => $days_in_a_row, 'xp' => 0]);
        (new Xp($user))->addForStreakDays();

        $this->assertEquals($expect_xp, User::whereId($user->id)->value('xp'));
    }

    /**
     * @author Cho
     * @test
     */
    public function getColor_method_returns_correct_color(): void
    {
        $user = create_user('', ['xp' => 1]);
        $xp = new Xp($user);
        $this->assertEquals('', $xp->getColor());

        $user->xp = $xp->levels[4]['min'];
        $this->assertEquals('gold-color', $xp->getColor());

        $user->xp = $xp->levels[7]['min'];
        $this->assertEquals('blue-color', $xp->getColor());

        $user->xp = $xp->levels[10]['min'];
        $this->assertEquals('purple-color', $xp->getColor());
    }
}
