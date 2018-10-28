<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Redis;
use Storage;

class DeleteImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $image_name;

    /**
     * Create a new job instance.
     *
     * @param string $image_name
     * @return void
     */
    public function __construct(string $image_name)
    {
        $this->image_name = $image_name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Redis::throttle('delete_image')->allow(2)->every(1)->then(function () {
            if ($this->image_name != 'default.jpg') {
                $this->deleteImagesFromStorage();
            }
        }, function () {
            return $this->release(2);
        });
    }

    /**
     * Deletes files from storage
     * @return boolean
     */
    public function deleteImagesFromStorage(): bool
    {
        return Storage::delete([
            "public/recipes/$this->image_name",
            "public/small/recipes/$this->image_name",
        ]);
    }

    /**
     * @codeCoverageIgnore
     * @return array
     */
    public function tags()
    {
        return ['delete_image'];
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
