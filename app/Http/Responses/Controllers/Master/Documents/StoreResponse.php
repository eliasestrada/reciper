<?php

namespace App\Http\Responses\Controllers\Master\Documents;

use App\Models\Document;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;

class StoreResponse implements Responsable
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
