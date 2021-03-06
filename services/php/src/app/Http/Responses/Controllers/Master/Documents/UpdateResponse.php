<?php

namespace App\Http\Responses\Controllers\Master\Documents;

use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Responsable;
use App\Models\Document;

class UpdateResponse implements Responsable
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
     * @return \Illuminate\Http\RedirectResponse|null
     */
    public function toResponse($request): ?RedirectResponse
    {
        try {
            $this->updateDocument($request);
            $this->cleanCache();
            return $this->response($request);
        } catch (QueryException $e) {
            return report_error($e);
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
        return $request->has('view')
            ? $this->showPreview()
            : $this->showEditPage($request);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function showEditPage($request): RedirectResponse
    {
        return $request->ready == 0
            ? back()->withSuccess(trans('documents.saved'))
            : back()->withSuccess(trans('documents.published'));
    }
}
