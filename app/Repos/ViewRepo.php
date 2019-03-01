<?php

namespace App\Repos;

use App\Models\View;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class ViewRepo
{
    /**
     * @param int|null $visitor_id
     * @return \Illuminate\Support\Collection
     */
    public function pluckViewedRecipeIds(?int $visitor_id): Collection
    {
        try {
            return View::whereVisitorId($visitor_id ?? visitor_id())
                ->pluck('recipe_id');
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return collect();
        }
    }
}
