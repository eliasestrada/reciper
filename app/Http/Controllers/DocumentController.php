<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\View\View;

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
            'ready_docs' => Document::query()->isReady(1)->paginate(20)->onEachSide(1),
            'unready_docs' => Document::query()->isReady(0)->paginate(20)->onEachSide(1),
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
