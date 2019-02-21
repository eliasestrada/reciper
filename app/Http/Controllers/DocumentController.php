<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Repos\DocumentRepo;
use App\Models\Document;

class DocumentController extends Controller
{
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
                    'docs' => DocumentRepo::paginateAllWithReadyStatus(1),
                    'name' => 'published',
                ],
                [
                    'docs' => DocumentRepo::paginateAllWithReadyStatus(0),
                    'name' => 'drafts',
                ],
            ],
        ]);
    }

    /**
     * Show single document page
     *
     * @param \App\Models\Document $document
     * @return mixed
     */
    public function show(Document $document)
    {
        if (!$document->isReady() && !optional(user())->hasRole('master')) {
            return redirect('/')->withError(trans('documents.not_ready'));
        }
        return view('documents.show', compact('document'));
    }
}
