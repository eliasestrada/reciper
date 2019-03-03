<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Repos\DocumentRepo;

class DocumentController extends Controller
{
    /**
     * @var \App\Repos\DocumentRepo $repo
     */
    private $repo;

    /**
     * @param \App\Repos\DocumentRepo $repo
     * @return void
     */
    public function __construct(DocumentRepo $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Show page with all documents
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        return view('documents.index', [
            'documents' => [
                [
                    'docs' => $this->repo->paginateWithReadyStatus(1),
                    'name' => 'published',
                ],
                [
                    'docs' => $this->repo->paginateWithReadyStatus(0),
                    'name' => 'drafts',
                ],
            ],
        ]);
    }

    /**
     * Show single document page
     *
     * @param int $document_id
     * @return mixed
     */
    public function show(int $document_id)
    {
        $document = $this->repo->find($document_id);

        if (!$document->isReady() && !optional(user())->hasRole('master')) {
            return redirect('/')->withError(trans('documents.not_ready'));
        }
        return view('documents.show', compact('document'));
    }
}
