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
    public static function add(float $xp_to_add, int $user_id)
    {
        $current_xp = User::whereId($user_id)->value('xp');
        $max_possible_level = config('custom.max_xp');

        if ($current_xp <= ($max_possible_level - $xp_to_add)) {
            return User::whereId($user_id)->increment('xp', $xp_to_add);
        } else {
            return User::whereId($user_id)->increment('xp', $max_possible_level - $current_xp);
        }
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        foreach ($this->levels as $level_index => $level_values) {
            if ($this->user->xp >= $level_values['min'] && $this->user->xp <= $level_values['max']) {
                return $level_index;
            }
        }
    }

    /**
     * @return int
     */
    public function minXpForCurrentLevel(): int
    {
        return $this->levels[$this->getLevel()]['min'];
    }

    /**
     * @return int
     */
    public function maxXpForCurrentLevel(): int
    {
        return $this->levels[$this->getLevel()]['max'];
    }

    /**
     * @return int
     */
    public function getPercent(): int
    {
        $current_clean = $this->user->xp - $this->minXpForCurrentLevel();
        $max_for_this_level = $this->maxXpForCurrentLevel() - $this->minXpForCurrentLevel();
        $result = 100 * $current_clean / $max_for_this_level;

        return $this->minXpForCurrentLevel() >= config('custom.max_xp') ? 100 : $result;
    }

    /**
     * @param User $user
     */
    public static function addForStreakDays(User $user)
    {
        $max_chained_days = 30;

        if ($user->streak_days <= $max_chained_days) {
            return self::add($user->streak_days, $user->id);
        } else {
            return self::add($max_chained_days, $user->id);
        }
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        if (in_array($this->getLevel(), range(1, 3))) {
            return '';
        }
        if (in_array($this->getLevel(), range(4, 6))) {
            return 'gold-color';
        }
        if (in_array($this->getLevel(), range(7, 9))) {
            return 'blue-color';
        }
        if ($this->getLevel() == 10) {
            return 'purple-color';
        }
    }
}
