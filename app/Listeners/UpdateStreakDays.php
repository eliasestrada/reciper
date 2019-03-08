<?php

namespace App\Listeners;

use Cookie;
use App\Models\Xp;
use App\Events\UserIsOnline;
use Illuminate\Database\QueryException;

class UpdateStreakDays
{
    /**
     * @var \App\Models\User|null
     */
    private $user;

    /**
     * @var \App\Models\Xp|null
     */
    private $xp;

    /**
     * @param \App\Events\UserIsOnline $event
     * @param \App\Models\Xp|null $xp
     * @param \App\Models\User|null $user
     * @return void
     */
    public function handle(UserIsOnline $event, ?Xp $xp = null, ?User $user = null)
    {
        $this->user = $user ?? user();
        $this->xp = $xp ?? new Xp;

        if (!request()->cookie('r_ekirts')) {
            Cookie::queue('r_ekirts', 1, 1440);

            if ($this->achivedStreakDays()) {
                $this->addOneMoreDayToStreakDaysRow();
                $this->xp->takeUser($this->user)->addForStreakDays();

                session()->flash('success', trans('messages.congrats_streak_days', [
                    'xp' => $this->user->streak_days,
                ]));
            }

            if ($this->failedStreakDays()) {
                $this->user->update(['streak_days' => 0, 'streak_check' => now()]);
            }
        }
    }

    /**
     * @return bool
     */
    public function achivedStreakDays(): bool
    {
        return $this->user->streak_check <= now()->subDay() &&
            $this->user->streak_check >= now()->subDays(2);
    }

    /**
     * @return bool
     */
    public function failedStreakDays(): bool
    {
        return $this->user->streak_check <= now()->subDays(2);
    }

    /**
     * @throws \Illuminate\Database\QueryException
     * @return void
     */
    public function addOneMoreDayToStreakDaysRow(): void
    {
        try {
            $this->user->update([
                'streak_days' => $this->user->streak_days + 1,
                'streak_check' => now(),
            ]);
        } catch (QueryException $e) {
            report_error($e);
        }
    }
}
