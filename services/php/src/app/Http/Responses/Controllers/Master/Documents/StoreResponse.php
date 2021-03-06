<?php

namespace App\Http\Responses\Controllers\Master\Documents;

use App\Models\Document;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Responsable;

class StoreResponse implements Responsable
{
    /**
     * @throws \Illuminate\Database\QueryException
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
            return report_error($e);
        }
    }
}
