<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentRequest;
use App\Http\Responses\Controllers\Master\Documents\DestroyResponse;
use App\Http\Responses\Controllers\Master\Documents\StoreResponse;
use App\Http\Responses\Controllers\Master\Documents\UpdateResponse;
use App\Models\Document;
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
     * Create new document in database
     *
     * @param \App\Http\Requests\DocumentRequest $request
     * @return \App\Http\Responses\Controllers\Master\Documents\StoreResponse
     */
    public function store(DocumentRequest $request): StoreResponse
    {
        return new StoreResponse;
    }

    /**
     * Return view with edit document form
     *
     * @param \App\Models\Document $document
     * @return \Illuminate\View\View
     */
    public function edit(Document $document): View
    {
        return view('master.documents.edit', compact('document'));
    }

    /**
     * Update given document
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
     * Delete given document
     *
     * @param \App\Models\Document $document
     * @return \App\Http\Responses\Controllers\Master\Documents\DestroyResponse
     */
    public function destroy(Document $document): DestroyResponse
    {
        return new DestroyResponse($document);
    }
}
