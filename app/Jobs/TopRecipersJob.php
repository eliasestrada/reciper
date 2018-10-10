<?php

namespace App\Jobs;

use App\Models\Like;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;

class TopRecipersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Redis::throttle('top-recipers')->allow(2)->every(1)->then(function () {
            $users = Like::whereCreatedAt(now()->subDay())->get()->map(function ($like) {
                return $like->recipe->user->id . '<split>' . $like->recipe->user->name;
            })->toArray();

            $users = array_slice(array_reverse(array_sort(array_count_values($users))), 0, 10);

            $top_recipers = [];

            foreach ($users as $name => $value) {
                $explode = explode('<split>', $name);
                array_push($top_recipers, [
                    'id' => $explode[0],
                    'name' => $explode[1],
                ]);
            }
            cache()->put('top_recipers', $top_recipers, 1440);
        }, function () {
            return $this->release(2);
        });
    }

    /**
     * @
     */
    public function tags()
    {
        return ['top_recipers'];
    }
}
