<?php

namespace App\Helpers;

use App\Models\User;

class Xp
{
    public $user;
    public $levels = [
        1 => ['min' => 1, 'max' => 39],
        2 => ['min' => 40, 'max' => 79],
        3 => ['min' => 80, 'max' => 159],
        4 => ['min' => 160, 'max' => 319],
        5 => ['min' => 320, 'max' => 639],
        6 => ['min' => 640, 'max' => 1279],
        7 => ['min' => 1280, 'max' => 2559],
        8 => ['min' => 2560, 'max' => 5119],
        9 => ['min' => 5120, 'max' => 9989],
        10 => ['min' => 9990, 'max' => 9991],
    ];

    /**
     * @param integer $user_id
     */
    public function __construct(int $user_id)
    {
        $this->user = User::find($user_id);
    }

    /**
     * @param int $user_id
     * @param float $points
     * @return void
     */
    public static function add(float $xp_add, int $user_id)
    {
        $xp_current = User::whereId($user_id)->value('xp');

        if ($xp_current <= (config('custom.max_xp') - $xp_add)) {
            User::whereId($user_id)->increment('xp', $xp_add);
        } else {
            User::whereId($user_id)->increment('xp', config('custom.max_xp') - $xp_current);
        }
    }

    /**
     * @param int $user_id
     * @param float $points
     * @return void
     */
    public static function remove(float $xp_remove, int $user_id)
    {
        User::whereId($user_id)->decrement('xp', $xp_remove);
    }

    /**
     * @return int
     */
    public function getLvl(): int
    {
        // Refactor
        $result = 0;
        foreach ($this->levels as $i => $level) {
            if ($this->user->xp >= $level['min'] && $this->user->xp <= $level['max']) {
                $result = $i;
            }
        }
        return $result;
    }

    /**
     * @return int
     */
    public function getLvlMin(): int
    {
        return $this->levels[$this->getLvl()]['min'];
    }

    /**
     * @return int
     */
    public function getLvlMax(): int
    {
        return $this->levels[$this->getLvl()]['max'];
    }

    /**
     * @return int
     */
    public function getPercent(): int
    {
        $min = $this->user->xp - $this->getLvlMin();
        $max = $this->getLvlMax() - $this->getLvlMin();
        return $this->getLvlMin() >= config('custom.max_xp') ? 100 : 100 * $min / $max;
    }

    /**
     * @param User $user
     * @return void
     */
    public static function addForStreak(User $user): void
    {
        if ($user->streak_days <= 30) {
            self::add($user->streak_days, $user->id);
        } else {
            self::add(30, $user->id);
        }
    }
}
