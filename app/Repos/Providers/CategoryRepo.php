<?php

namespace App\Repos\Providers;

use App\Models\Category;
use Illuminate\Database\QueryException;

class CategoryRepo
{
    /**
     * @return array
     */
    public function getCache(): array
    {
        $categories = cache()->rememberForever('categories', function () {
            try {
                return Category::get()->toArray();
            } catch (QueryException $e) {
                return report_error($e, []);
            }
        });

        return array_map(function ($cat) {
            return ['id' => $cat['id'], 'name' => $cat[_('name')]];
        }, $categories);
    }
}
