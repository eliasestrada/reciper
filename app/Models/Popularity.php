<?php

namespace App\Models;

use App\Models\User;

class Popularity
{
    /**
     * @var \App\Models\User $user
     */
    protected $user;

    /**
     * @param \App\Models\User $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
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
