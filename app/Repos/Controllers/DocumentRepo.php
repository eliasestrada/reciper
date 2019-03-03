<?php

namespace App\Repos\Controllers;

use App\Models\Document;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repos\Controllers\Base\DocumentRepoBase;

class DocumentRepo extends DocumentRepoBase
{
    /**
     * @param int $ready
     * @return \Illuminate\Pagination\LenghtAwarePaginator
     */
    public function paginateWithReadyStatus(int $ready = 1): ?LengthAwarePaginator
    {
        try {
            return Document::query()->isReady($ready)->paginate(20)->onEachSide(1);
        } catch (QueryException $e) {
            return report_error($e);
        }
    }
}
