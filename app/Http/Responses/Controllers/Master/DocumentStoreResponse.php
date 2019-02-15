<?php

namespace App\Http\Responses\Controllers\Master;

use App\Models\Document;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;

class DocumentStoreResponse implements Responsable
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|null
     */
    public function toResponse($request): ?RedirectResponse
    {
        try {
            $document = Document::create([
                _('title') => $request->title,
                _('text') => $request->text,
            ]);
            return redirect("/master/documents/{$document->id}/edit");
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return null;
        }
    }
}
