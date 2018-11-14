<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentsRequest;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('master')->except(['index', 'show']);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('documents.index', [
            'ready_docs' => Document::query()->isReady(1)->paginate(20)->onEachSide(1),
            'unready_docs' => Document::query()->isReady(0)->paginate(20)->onEachSide(1),
        ]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('documents.create');
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentsRequest $request)
    {
        $doc = Document::create([
            'title_' . LANG() => $request->title,
            'text_' . LANG() => $request->text,
        ]);

        return redirect("/documents/$doc->id/edit");
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        if (!$document->isReady() && !optional(user())->hasRole('master')) {
            return redirect('/')->withError(trans('documents.not_ready'));
        }
        return view('documents.show', compact('document'));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        return view('documents.edit', compact('document'));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentsRequest $request, Document $document)
    {
        $document->update([
            'title_' . LANG() => $request->title,
            'text_' . LANG() => $request->text,
            'ready_' . LANG() => $request->ready == 1 || $document->id == 1 ? 1 : 0,
        ]);

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Check for correct user
        if (!user()->hasRole('master')) {
            return redirect('/')->withError(
                trans('documents.only_master_can_delete')
            );
        }

        if ($id == 1) {
            return redirect('/documents/create')
                ->withError(trans('documents.cant_delete_first_doc'));
        }

        Document::find($id)->delete();

        return redirect('/documents')->withSuccess(
            trans('documents.doc_has_been_deleted')
        );
    }
}
