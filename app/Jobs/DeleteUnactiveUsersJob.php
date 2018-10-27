<?php

namespace App\Jobs;

use App\Models\User;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteUnactiveUsersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::where('updated_at', '<=', now()->subDays(30))->whereActive(0)->get();

        foreach ($users as $user) {
            DeletePhotoJob::dispatch($user->photo);
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
