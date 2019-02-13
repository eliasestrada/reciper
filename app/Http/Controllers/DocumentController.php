<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequest;
use App\Models\Document;
use App\Repos\DocumentRepo;
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
        $this->middleware('master')->except(['index', 'show']);
    }

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
     * Show create document page
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('documents.create');
    }

    /**
     * Create document in database
     *
     * @param  \App\Http\Requests\DocumentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DocumentRequest $request): RedirectResponse
    {
        $doc = DocumentRepo::create($request);
        return redirect("/documents/{$doc->id}/edit");
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

    /**
     * Edit document page
     *
     * @param \App\Models\Document $document
     * @return \Illuminate\View\View
     */
    public function edit(Document $document): View
    {
        return view('documents.edit', compact('document'));
    }

    /**
     * Update existing document
     *
     * @param \App\Http\Requests\DocumentRequest $requet
     * @param \App\Models\Document $document
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(DocumentRequest $request, Document $document): RedirectResponse
    {
        DocumentRepo::update($request, $document);

        if ($request->has('view')) {
            return redirect("/documents/$document->id");
        }

        if ($document->id == 1) {
            cache()->forget('document_agreement');
        }

        return $request->ready == 0
        ? back()->withSuccess(trans('documents.saved'))
        : back()->withSuccess(trans('documents.published'));
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
            return redirect('/documents/create')->withError(
                trans('documents.cant_delete_first_doc')
            );
        }

        Document::find($id)->delete();

        return redirect('/documents')->withSuccess(
            trans('documents.doc_has_been_deleted')
        );
    }
}
