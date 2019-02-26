<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DeleteFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $filename;

    /**
     * Create a new job instance.
     *
     * @param mixed $filename
     * @return void
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Redis::throttle('delete-file')->allow(2)->every(1)->then(function () {
            $this->deleteFile();
        }, function () {
            return $this->release(2);
        });
    }

    /**
     * @return void
     */
    public function deleteFile(): void
    {
        \Storage::delete($this->filename);
    }
}
