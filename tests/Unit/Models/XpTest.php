<?php

namespace Tests\Unit\Models;

use App\Helpers\Xp;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class XpTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function model_has_attributes(): void
    {
        $this->assertClassHasAttribute('user', Xp::class);
        $this->assertClassHasAttribute('levels', Xp::class);
    }

    /** @test */
    public function getLvl_method_returns_correct_data(): void
    {
        $xp = new Xp(create_user('')->id);

        foreach ($xp->levels as $i => $level) {
            $xp->user->xp = rand($level['min'], $level['max']);
            $this->assertEquals($i, $xp->getLvl());
        }
    }

    /** @test */
    public function getLvlMin_method_returns_correct_data(): void
    {
        $xp = new Xp(create_user('')->id);

        foreach ($xp->levels as $level) {
            $xp->user->xp = rand($level['min'], $level['max']);
            $this->assertEquals($level['min'], $xp->getLvlMin());
        }
    }

    /** @test */
    public function getLvlMax_method_returns_correct_data(): void
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
            if ($i !== 10) {
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
    public function add_method_adds_xp(): void
    {
        $user = create_user('', ['xp' => 0]);
        $response = Xp::add(32, $user->id);
        $this->assertTrue((bool) $response);
    }

    /** @test */
    public function addForStreak_method_adds_certain_xp_points(): void
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
            $response = Xp::addForStreak($user);
            $this->assertTrue((bool) $response);
        }
    }
}