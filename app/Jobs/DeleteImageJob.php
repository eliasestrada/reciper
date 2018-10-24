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
                Storage::delete([
                    "public/users/$this->image_name",
                    "public/small/users/$this->image_name",
                ]);
            }
        }, function () {
            return $this->release(2);
        });
    }

    /**
     * @return array
     */
    public function tags()
    {
        return ['delete_image'];
    }
}
