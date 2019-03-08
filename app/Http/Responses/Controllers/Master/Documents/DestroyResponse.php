<?php

namespace App\Http\Responses\Controllers\Master\Documents;

use App\Models\Document;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Responsable;

class DestroyResponse implements Responsable
{
    /**
     * @var \App\Models\Document
     */
    private $document;

    /**
     * @param \App\Models\Document|null $document
     * @return void
     */
    public function __construct(?Document $document)
    {
        $this->document = $document;
    }

    /**
     * @throws \Illuminate\Database\QueryException
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toResponse($request): RedirectResponse
    {
        try {
            if ($this->isFirstDocument()) {
                return $this->cantDeleteResponse();
            }
            $this->document->delete();
            return $this->successResponse();
        } catch (QueryException $e) {
            return report_error($e, redirect('/documents'));
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function cantDeleteResponse(): RedirectResponse
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
