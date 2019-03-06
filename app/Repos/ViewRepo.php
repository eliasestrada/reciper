<?php

namespace App\Repos;

use App\Models\View;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class ViewRepo
{
    /**
     * @throws \Illuminate\Database\QueryException
     * @param int|null $visitor_id
     * @return \Illuminate\Support\Collection
     */
    public function pluckViewedRecipeIds(?int $visitor_id = null): Collection
    {
        $visitor_id = $visitor_id ?? visitor_id();

        try {
            return View::whereVisitorId($visitor_id)->pluck('recipe_id');
        } catch (QueryException $e) {
            return report_error($e, collect());
        }
    }
}
