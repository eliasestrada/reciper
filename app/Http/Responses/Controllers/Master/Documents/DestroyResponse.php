<?php

namespace App\Http\Responses\Controllers\Master\Documents;

use App\Models\Document;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Responsable;

class DestroyResponse implements Responsable
{
    protected $document;

    /**
     * @param \App\Models\Document $document
     * @return void
     */
    public function __construct(Document $document)
    {
        $this->document = $document;
    }
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toResponse($request): RedirectResponse
    {
        try {
            if ($this->isFirstDocument()) {
                return $this->cantDelete();
            }
            $this->document->delete();
            return $this->successResponse();
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return redirect('/documents');
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function cantDelete(): RedirectResponse
    {
        return redirect('/master/documents/create')->withError(
            trans('documents.cant_delete_first_doc')
        );
    }

    /**
     * @return bool
     */
    protected function isFirstDocument(): bool
    {
        return $this->document->id == 1;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function successResponse(): RedirectResponse
    {
        return redirect('/documents')->withSuccess(
            trans('documents.doc_has_been_deleted')
        );
    }
}
