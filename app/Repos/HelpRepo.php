<?php

namespace App\Repos;

use App\Models\Help;
use Illuminate\Database\QueryException;

class HelpRepo
{
    /**
     * @return array
     */
    public function getCache(): array
    {
        $cache_time = config('cache.timing.help_list');

        try {
            return cache()->remember('help_list', $cache_time, function () {
                return Help::orderBy(_('title'))->get()->toArray();
            });
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return [];
        }
    }
}
