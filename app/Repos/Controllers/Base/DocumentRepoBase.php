<?php

namespace App\Repos\Controllers\Base;

use App\Models\Document;
use Illuminate\Database\QueryException;

class DocumentRepoBase
{
    /**
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
}
