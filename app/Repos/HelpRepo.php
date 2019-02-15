<?php

namespace App\Repos;

use App\Models\Help;

class HelpRepo
{
    /**
     * @return array
     */
    public static function getCache(): array
    {
        return cache()->remember('help_list', 10, function () {
            return Help::orderBy(_('title'))->get()->toArray();
        });
    }
}
