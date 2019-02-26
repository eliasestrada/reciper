<?php

namespace App\Repos;

use App\Models\Document;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;

class DocumentRepo
{
    /**
     * @param int $document_id
     * @return \App\Models\Document
     */
    public function find(int $document_id): Document
    {
        return Document::find($document_id);
    }

    /**
     * @param int $ready
     * @return \Illuminate\Pagination\LenghtAwarePaginator
     */
    public function paginateAllWithReadyStatus(int $ready = 1): ?LengthAwarePaginator
    {
        try {
            return Document::query()->isReady($ready)->paginate(20)->onEachSide(1);
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return null;
        }
    }
}
