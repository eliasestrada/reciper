<?php

namespace App\Repos;

use App\Http\Requests\DocumentRequest;
use App\Models\Document;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class DocumentRepo
{
    /**
     * @param  \App\Http\Requests\DocumentRequest $request
     * @return \App\Models\Document
     */
    public static function create(DocumentRequest $request): Document
    {
        try {
            return Document::create([
                _('title') => $request->title,
                _('text') => $request->text,
            ]);
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return collect();
        }
    }
}
