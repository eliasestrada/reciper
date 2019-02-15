<?php

namespace App\Repos;

use App\Models\Document;
use Illuminate\Pagination\LengthAwarePaginator;

class DocumentRepo
{
    /**
     * @param int $ready
     * @return \Illuminate\Pagination\LenghtAwarePaginator
     */
    public static function paginateAllWithReadyStatus(int $ready = 1): LengthAwarePaginator
    {
        return Document::query()->isReady($ready)->paginate(20)->onEachSide(1);
    }
}
