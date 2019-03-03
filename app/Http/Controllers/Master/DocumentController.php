<?php

namespace App\Http\Controllers\Master;

use App\Models\Document;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentRequest;
use App\Repos\Controllers\Master\DocumentRepo;
use App\Http\Responses\Controllers\Master\Documents\StoreResponse;
use App\Http\Responses\Controllers\Master\Documents\UpdateResponse;
use App\Http\Responses\Controllers\Master\Documents\DestroyResponse;

class DocumentController extends Controller
{
    /**
     * @var \App\Repos\Controllers\Master\DocumentRepo $repo
     */
    private $repo;

    /**
     * @return void
     */
    public function __construct(DocumentRepo $repo)
    {
        $this->middleware('master');
        $this->repo = $repo;
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
     * @param int $id Document id
     * @return \Illuminate\View\View
     */
    public function edit(int $id): View
    {
        return view('master.documents.edit', [
            'document' => $this->repo->find($id),
        ]);
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
