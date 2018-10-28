<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Redis;
use Storage;

class DeletePhotoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $photo_name;

    /**
     * Create a new job instance.
     *
     * @param string $photo_name
     * @return void
     */
    public function __construct(string $photo_name)
    {
        $this->photo_name = $photo_name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Redis::throttle('delete_photo')->allow(2)->every(1)->then(function () {
            if ($this->photo_name != 'default.jpg') {
                $this->deletePhotosFromStorage();
            }
        }, function () {
            return $this->release(2);
        });
    }

    /**
     * Deletes files from storage
     * @return boolean
     */
    public function deletePhotosFromStorage(): bool
    {
        return Storage::delete([
            "public/users/$this->photo_name",
            "public/small/users/$this->photo_name",
        ]);
    }

    /**
     * @codeCoverageIgnore
     * @return array
     */
    public function tags()
    {
        return ['delete_photo'];
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
