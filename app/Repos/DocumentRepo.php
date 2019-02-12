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

    /**
     * @param  \App\Http\Requests\DocumentRequest $request
     * @param \App\Models\Document $document
     * @return void
     */
    public static function update(DocumentRequest $request, Document $document): void
    {
        try {
            $document->update([
                _('title') => $request->title,
                _('text') => $request->text,
                _('ready') => $request->ready == 1 || $document->id == 1 ? 1 : 0,
            ]);
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
        }
    }
}
