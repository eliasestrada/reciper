<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentRequest;
use App\Http\Responses\Controllers\Master\Documents\StoreResponse;
use App\Http\Responses\Controllers\Master\Documents\UpdateResponse;
use App\Models\Document;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DocumentController extends Controller
{
    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('master');
    }

    /**
     * Show create document page
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('master.documents.create');
    }

    /**
     * Create document in database
     *
     * @param \App\Http\Requests\DocumentRequest $request
     * @return \App\Http\Responses\Controllers\Master\Documents\StoreResponse
     */
    public function store(DocumentRequest $request): StoreResponse
    {
        return new StoreResponse;
    }

    /**
     * Edit document page
     *
     * @param \App\Models\Document $document
     * @return \Illuminate\View\View
     */
    public function edit(Document $document): View
    {
        return view('master.documents.edit', compact('document'));
    }

    /**
     * Update existing document
     *
     * @param \App\Http\Requests\DocumentRequest $requet
     * @param \App\Models\Document $document
     * @return \App\Http\Responses\Controllers\Master\Documents\UpdateResponse
     */
    public function update(DocumentRequest $request, Document $document): UpdateResponse
    {
        return new UpdateResponse($document);
    }

    /**
     * Delete document
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        if ($id == 1) {
            return redirect('/master/documents/create')->withError(
                trans('documents.cant_delete_first_doc')
            );
        }

        Document::find($id)->delete();

        return redirect('/documents')->withSuccess(
            trans('documents.doc_has_been_deleted')
        );
    }
}
