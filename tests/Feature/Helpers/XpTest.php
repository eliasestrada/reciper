<?php

namespace Tests\Feature\Helpers;

use App\Helpers\Xp;
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
     * @see \App\Helpers\Xp, it takes user and return his current xp
     * @author Cho
     * @test
     */
    public function getLevel_method_returns_current_users_level_depending_on_users_current_xp(): void
    {
        $xp = new Xp(create_user());

        foreach ($xp->levels as $i => $level) {
            $xp->user->xp = rand($level['min'], $level['max']);
            $this->assertEquals($i, $xp->getLevel());
        }
    }

    /**
     * @author Cho
     * @test
     */
    public function getLevelMin_method_returns_minimum_value_of_xp_for_current_users_level(): void
    {
        $xp = new Xp(create_user());

        foreach ($xp->levels as $level) {
            $xp->user->xp = rand($level['min'], $level['max']);
            $this->assertEquals($level['min'], $xp->getLevelMin());
        }
    }

    /**
     * @author Cho
     * @test
     */
    public function getLevelMax_method_returns_maximum_value_of_xp_for_current_users_level(): void
    {
        $xp = new Xp(create_user());

        foreach ($xp->levels as $level) {
            $xp->user->xp = rand($level['min'], $level['max']);
            $this->assertEquals($level['max'], $xp->getLevelMax());
        }
    }

    /**
     * 0% - beggining of the level
     * 99% - the end of the level
     * @author Cho
     * @test
     */
    public function getPercent_method_shows_percent_of_current_level(): void
    {
        $current_xp = new Xp(create_user());

        foreach ($current_xp->levels as $i => $level) {
            if ($i !== 10) {
                $current_xp->user->xp = $level['min'];
                $this->assertEquals(0, $current_xp->getPercent());
            } else {
                $current_xp->user->xp = $level['min'];
                $this->assertEquals(100, $current_xp->getPercent());
            }

            $current_xp->user->xp = $level['max'];
            $this->assertEquals(100, $current_xp->getPercent());
        }
    }

    /**
     * @author Cho
     * @test
     */
    public function add_method_adds_xp_and_returns_true_if_added_successfuly(): void
    {
        $user = create_user('', ['xp' => 0]);
        $response = Xp::add(32, $user->id);
        $this->assertTrue((bool) $response);
    }

    /**
     * @author Cho
     * @test
     */
    public function addForStreakDays_method_adds_certain_xp_points(): void
    {
        $user = create_user('', ['xp' => 0]);

        $days = [
            ['streak_days' => 1, 'expect_xp' => 1],
            ['streak_days' => 13, 'expect_xp' => 14],
            ['streak_days' => 29, 'expect_xp' => 43],
            ['streak_days' => 30, 'expect_xp' => 73],
            ['streak_days' => 31, 'expect_xp' => 103],
        ];

        foreach ($days as $day) {
            $user->update(['streak_days' => $day['streak_days']]);
            $response = Xp::addForStreakDays($user);
            $this->assertTrue((bool) $response);
        }
    }
}
