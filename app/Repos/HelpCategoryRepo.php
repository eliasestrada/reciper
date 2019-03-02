<?php

namespace App\Repos;

use App\Models\HelpCategory;

class HelpCategoryRepo
{
    /**
     * @return array
     */
    public function getCache(): array
    {
        $cache_time = config('cache.timing.help_categories');

        try {
            return cache()->remember('help_categories', $cache_time, function () {
                return HelpCategory::get()->toArray();
            });
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return [];
        }
    }
}
