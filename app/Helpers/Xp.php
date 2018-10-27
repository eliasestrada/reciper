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
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param int $user_id
     * @param float $points
     */
    public static function add(float $xp_add, int $user_id)
    {
        $xp_current = User::whereId($user_id)->value('xp');

        if ($xp_current <= (config('custom.max_xp') - $xp_add)) {
            return User::whereId($user_id)->increment('xp', $xp_add);
        } else {
            return User::whereId($user_id)->increment('xp', config('custom.max_xp') - $xp_current);
        }
    }

    /**
     * @return int
     */
    public function getLevel(): int
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
    public function getLevelMin(): int
    {
        return $this->levels[$this->getLevel()]['min'];
    }

    /**
     * @return int
     */
    public function getLevelMax(): int
    {
        return $this->levels[$this->getLevel()]['max'];
    }

    /**
     * @return int
     */
    public function getPercent(): int
    {
        $min = $this->user->xp - $this->getLevelMin();
        $max = $this->getLevelMax() - $this->getLevelMin();
        return $this->getLevelMin() >= config('custom.max_xp') ? 100 : 100 * $min / $max;
    }

    /**
     * @param User $user
     */
    public static function addForStreakDays(User $user)
    {
        if ($user->streak_days <= 30) {
            return self::add($user->streak_days, $user->id);
        } else {
            return self::add(30, $user->id);
        }
    }
}
