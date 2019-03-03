<?php

namespace App\Http\Controllers\Master;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentRequest;
use App\Repos\DocumentRepo;
use App\Http\Responses\Controllers\Master\Documents\StoreResponse;
use App\Http\Responses\Controllers\Master\Documents\UpdateResponse;
use App\Http\Responses\Controllers\Master\Documents\DestroyResponse;

class DocumentController extends Controller
{
    /**
     * @var \App\Repos\DocumentRepo $repo
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
     * @param int $id
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
     * @param int $id
     * @return \App\Http\Responses\Controllers\Master\Documents\UpdateResponse
     */
    public function update(DocumentRequest $request, int $id): UpdateResponse
    {
        return new UpdateResponse($id, $this->repo);
    }

    /**
     * Delete given document
     *
     * @param int $id
     * @return \App\Http\Responses\Controllers\Master\Documents\DestroyResponse
     */
    public function destroy(int $id): DestroyResponse
    {
        return new DestroyResponse($id, $this->repo);
    }
}
