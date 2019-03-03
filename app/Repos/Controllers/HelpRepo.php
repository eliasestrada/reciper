<?php

namespace App\Repos\Controllers;

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
            return report_error($e, []);
        }
    }

    /**
     * @param int $id
     * @return \App\Models\Help|null
     */
    public function find(int $id): ?Help
    {
        try {
            return Help::find($id);
        } catch (QueryException $e) {
            report_error($e, __CLASS__);
            return null;
        }
    }
}
