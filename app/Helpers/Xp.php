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
     * @param float $points
     */
    public function add(float $xp_to_add)
    {
        $current_xp = $this->user->xp;
        $max_possible_level = config('custom.max_xp');

        if ($current_xp <= ($max_possible_level - $xp_to_add)) {
            return $this->user->increment('xp', $xp_to_add);
        } else {
            return $this->increment('xp', $max_possible_level - $current_xp);
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
     * $max_points is the value of how many days xp points
     * for steak days will grow. After that value xp will be consist
     * and equal to this $max_points
     *
     * User cannot have more than $max_points xp points
     * for one day
     *
     * @return bool
     */
    public function addForStreakDays(): bool
    {
        $max_points = 30.0;

        return $this->user->streak_days <= $max_points
            ? $this->add($this->user->streak_days)
            : $this->add($max_points);
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        switch (true) {
            case in_array($this->getLevel(), range(1, 3)):
                return '';
                break;

            case in_array($this->getLevel(), range(4, 6)):
                return 'gold-color';
                break;

            case in_array($this->getLevel(), range(7, 9)):
                return 'blue-color';
                break;

            case $this->getLevel() == 10:
                return 'purple-color';
        }
    }
}
