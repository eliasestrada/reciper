<?php

namespace App\Repos\Providers;

use App\Models\Category;
use Illuminate\Database\QueryException;

class CategoryRepo
{
    /**
     * Get all categories in array
     *
     * @return array
     */
    public function getAllInArray(): array
    {
        try {
            return Category::get()->toArray();
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return [];
        }
    }
}
