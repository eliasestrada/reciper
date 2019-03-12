<?php

namespace App\Models;

class Popularity
{
    /**
     * @var \App\Models\User
     */
    public $user;

    /**
     * @param \App\Models\User $user
     * @return \App\Models\Popularity
     */
    public function takeUser(User $user): Popularity
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @param float $points
     * @return void
     */
    public function add(float $points): void
    {
        $this->user->increment('popularity', $points);
    }

    /**
     * @param float $points
     * @return void
     */
    public function remove(float $points): void
    {
        $this->user->decrement('popularity', $points);
    }
}
