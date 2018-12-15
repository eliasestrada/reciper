<?php

namespace App\Repos;

use App\Models\HelpCategory;

class HelpCategoryRepo
{
    /**
     * @return array
     */
    public static function getCache(): array
    {
        try {
            return cache()->remember('help_categories', 10, function () {
                return HelpCategory::select('id', 'title_' . LANG() . ' as title', 'icon')
                    ->get()
                    ->toArray();
            });
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return collect();
        }
    }
}
