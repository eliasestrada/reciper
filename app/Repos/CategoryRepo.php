<?php

namespace App\Repos;

use App\Models\Category;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class CategoryRepo
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public static function get(): Collection
    {
        try {
            return Category::get();
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return collect();
        }
    }
}
