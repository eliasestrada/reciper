<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Notifications\DatabaseNotification;

// class DeleteNotificationsJob implements ShouldQueue
class DeleteNotificationsJob
{
    // use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use Dispatchable, Queueable;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // \Redis::throttle('delete-notifications')->allow(2)->every(1)->then(function () {
        $this->deleteNotifications();
        // }, function () {
        // return $this->release(2);
        // });
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

    /**
     * @return bool
     */
    public function deleteNotifications(): bool
    {
        return DatabaseNotification::whereNotNull('read_at')->delete();
    }
}
