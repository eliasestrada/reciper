<?php

namespace App\Http\Responses\Controllers\Master\Documents;

use App\Models\Document;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;

class UpdateResponse implements Responsable
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
     * @return \Illuminate\Http\RedirectResponse|null
     */
    public function toResponse($request): ?RedirectResponse
    {
        try {
            $this->updateDocument($request);
            $this->cleanCache();
            return $this->response($request);
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return null;
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function updateDocument($request): void
    {
        $this->document->update([
            _('title') => $request->title,
            _('text') => $request->text,
            _('ready') => $request->ready == 1 || $this->document->id == 1 ? 1 : 0,
        ]);
    }

    /**
     * @return void
     */
    protected function cleanCache(): void
    {
        if ($this->document->id == 1) {
            cache()->forget('document_agreement');
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function response($request)
    {
        return $request->has('view') ? $this->showPreview() : $this->showEditPage();
    }

    /**
     * @return void
     */
    protected function showPreview()
    {
        return redirect("/documents/{$this->document->id}");
    }

    /**
     * Check if recipe is being saved or published
     * and return redirect back with message
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function showEditPage(): RedirectResponse
    {
        return $request->ready == 0
        ? back()->withSuccess(trans('documents.saved'))
        : back()->withSuccess(trans('documents.published'));
    }
}
