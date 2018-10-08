<?php

namespace Tests\Unit;

use App\Helpers\Xp;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class XpTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function get_lvl_method_returns_correct_data(): void
    {
        $xp = new Xp(create_user('')->id);

        foreach ($xp->levels as $level) {
            $xp->user->xp = rand($level['min'], $level['max']);
            $this->assertEquals($level['lvl'], $xp->getLvl());
        }
    }

    /** @test */
    public function get_lvl_min_method_returns_correct_data(): void
    {
        $xp = new Xp(create_user('')->id);

        foreach ($xp->levels as $level) {
            $xp->user->xp = rand($level['min'], $level['max']);
            $this->assertEquals($level['min'], $xp->getLvlMin());
        }
    }

    /** @test */
    public function get_lvl_max_method_returns_correct_data(): void
    {
        $xp = new Xp(create_user('')->id);

        foreach ($xp->levels as $level) {
            $xp->user->xp = rand($level['min'], $level['max']);
            $this->assertEquals($level['max'], $xp->getLvlMax());
        }
    }

    /** @test */
    public function scaling_div_is_showing_correct_data(): void
    {
        $xp = new Xp(create_user('')->id);

        foreach ($xp->levels as $i => $level) {
            if ($level['lvl'] !== 10) {
                $xp->user->xp = $level['min'];
                $this->assertEquals(0, $xp->getPercent());
            } else {
                $xp->user->xp = $level['min'];
                $this->assertEquals(100, $xp->getPercent());
            }

            $xp->user->xp = $level['max'];
            $this->assertEquals(100, $xp->getPercent());
        }
    }

    /** @test */
    public function add_for_streak_method_adds_certain_xp_points(): void
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
            Xp::addForStreak($user);
            $this->assertDatabaseHas('users', ['id' => $user->id, 'xp' => $day['expect_xp']]);
        }
    }
}
