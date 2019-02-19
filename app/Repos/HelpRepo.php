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
        try {
            return cache()->remember('help_list', 10, function () {
                return Help::orderBy(_('title'))->get()->toArray();
            });
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return [];
        }
    }
}
