<?php

namespace App\Repos;

use App\Models\Document;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repos\Base\DocumentRepoBase;

class DocumentRepo
{
    /**
     * @throws \Illuminate\Database\QueryException
     * @param int $document_id
     * @return \App\Models\Document|null
     */
    public function find(int $document_id): ?Document
    {
        try {
            return Document::find($document_id);
        } catch (QueryException $e) {
            return report_error($e);
        }
    }

    /**
     * @throws \Illuminate\Database\QueryException
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
