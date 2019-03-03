<?php

namespace App\Http\Responses\Controllers\Master\Documents;

use Illuminate\Http\RedirectResponse;
use App\Repos\DocumentRepo;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Responsable;

class DestroyResponse implements Responsable
{
    /**
     * @var \App\Models\Document $document
     */
    private $document;

    /**
     * @param int $id
     * @param \App\Repos\DocumentRepo $repo
     * @return void
     */
    public function __construct(int $id, DocumentRepo $repo)
    {
        $this->document = $repo->find($id);
    }

    /**
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
