<?php

namespace App\Jobs;

use App\Models\Like;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        \Redis::throttle('top-recipers')->allow(2)->every(1)->then(function () {
            $top_recipers = $this->makeListOfTopRecipers();
            cache()->put('top_recipers', $top_recipers, 1440);
        }, function () {
            return $this->release(2);
        });
    }

    /**
     * Function helper covered by tests
     * @return array
     */
    public function makeListOfTopRecipers(): array
    {
        $likes = Like::where([
            ['created_at', '>=', Carbon::yesterday()->startOfDay()],
            ['created_at', '<=', Carbon::yesterday()->endOfDay()],
        ])->get();

        $users = $this->getArrayOfUsernames($likes);
        $top_recipers = $this->combineArrayValues($users);

        return $top_recipers;
    }

    /**
     * @codeCoverageIgnore
     * @return array
     */
    public function tags()
    {
        return ['top_recipers'];
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
     * @param array $before
     * @return array
     */
    public function combineArrayValues(array $before): array
    {
        $count_values = array_count_values($before);
        $sort = array_sort($count_values);
        $revers = array_reverse($sort);
        return array_slice($revers, 0, 7);
    }

    /**
     * @param Collection $likes
     * @return array
     */
    public function getArrayOfUsernames(Collection $likes): array
    {
        return $likes->map(function ($like) {
            return $like->recipe->user->username;
        })->toArray();
    }
}
