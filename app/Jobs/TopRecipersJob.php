<?php

namespace App\Jobs;

use App\Models\Like;
use App\Models\User;
use Carbon\Carbon;
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
            $this->bestReciperOfYesterdayScript();
        }, function () {
            return $this->release(2);
        });
    }

    /**
     * Script that handles the job
     *
     * @return void
     */
    public function bestReciperOfYesterdayScript(): void
    {
        $users = Like::where([
            ['created_at', '>=', Carbon::yesterday()->startOfDay()],
            ['created_at', '<=', Carbon::yesterday()->endOfDay()],
        ])->get()->map(function ($like) {
            return $like->recipe->user->username;
        })->toArray();

        $top_recipers = array_slice(array_reverse(array_sort(array_count_values($users))), 0, 7);

        cache()->put('top_recipers', $top_recipers, 1440);
    }

    public function tags()
    {
        return ['top_recipers'];
    }
}
