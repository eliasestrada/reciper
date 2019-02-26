<?php

namespace App\Jobs;

use Exception;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class DeleteUnactiveUsersJob
{
    use Dispatchable, Queueable;

    /**
     * Loop through all unactive users and delete them with
     * their photos
     *
     * @see DeleteFileJob
     * @return void
     */
    public function handle()
    {
        $users = User::where('updated_at', '<=', now()->subDays(30))->whereActive(0)->get();

        foreach ($users as $user) {
            if ($user->photo != 'default.jpg') {
                DeleteFileJob::dispatch($user->photo);
            }

            if ($user->roles()) {
                $user->roles()->detach();
            }

            if ($user->favs()) {
                $user->favs()->delete();
            }

            $user->delete();
        }
    }

    /**
     * Job failed to process
     *
     * @codeCoverageIgnore
     * @return void
     */
    public function failed(Exception $e)
    {
        info(__CLASS__ . " failed to proceed: {$e->getMessage()}");
    }
}
