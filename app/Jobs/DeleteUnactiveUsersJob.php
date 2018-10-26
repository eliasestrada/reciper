<?php

namespace App\Jobs;

use App\Models\User;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class DeleteUnactiveUsersJob
{
    use Dispatchable, Queueable;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        User::where('updated_at', '<=', now()->subDays(30))->whereActive(0)->delete();
    }

    /**
     * Job failed to process
     *
     * @return void
     */
    public function failed(Exception $e)
    {
        info(__CLASS__ . " failed to proceed: {$e->getMessage()}");
    }
}
