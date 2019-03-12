<?php

namespace App\Repos;

use App\Models\Category;
use Illuminate\Database\QueryException;

class CategoryRepo
{
    /**
     * @throws \Illuminate\Database\QueryException
     * @return array
     */
    public function getCache(): array
    {
        try {
            $categories = cache()->rememberForever('categories', function () {
                return Category::get()->toArray();
            });

            return array_map(function ($cat) {
                return ['id' => $cat['id'], 'name' => $cat[_('name')]];
            }, $categories);
        } catch (QueryException $e) {
            return report_error($e, []);
        }
    }
}
