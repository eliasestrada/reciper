<?php

namespace App\Jobs;

use App\Models\TopRecipers;
use App\Models\Like;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;

class TopRecipersJob
{
    use Dispatchable, Queueable;

    /**
     * Execute the job.
     * @codeCoverageIgnore
     * @return void
     */
    public function handle()
    {
        $list_of_top_recipers = $this->makeCachedListOfTopRecipers();
        $this->saveWinnersToDatabase($list_of_top_recipers);
    }

    /**
     * Function helper covered by tests
     * @return array
     */
    public function makeCachedListOfTopRecipers(): array
    {
        $likes = Like::where([
            ['created_at', '>=', Carbon::yesterday()->startOfDay()],
            ['created_at', '<=', Carbon::yesterday()->endOfDay()],
        ])->get();

        $users = $this->getArrayOfUsernames($likes);
        $top_recipers = $this->combineArrayValues($users);

        cache()->put('top_recipers', $top_recipers, 1440);

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

    /**
     * @param array $list
     * @return bool
     */
    public function saveWinnersToDatabase(array $list): bool
    {
        $result = array_filter($list, function ($item) use ($list) {
            return $item == array_shift($list);
        });

        return TopRecipers::add(array_keys($result));
    }
}
