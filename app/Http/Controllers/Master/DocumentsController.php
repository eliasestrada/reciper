<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentsRequest;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentsController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.documents.index', [
            'ready_docs' => Document::query()->ready(1)->paginate(20)->onEachSide(1),
            'unready_docs' => Document::query()->ready(0)->paginate(20)->onEachSide(1),
        ]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.documents.create');
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentsRequest $request)
    {
        $doc = Document::create([
            'title_' . lang() => $request->title,
            'text' => $request->text,
        ]);

        return redirect("/master/documents/$doc->id/edit");
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        if (!$document->isReady() && !optional(user())->hasRole('master')) {
            return redirect('/')->withError(trans('documents.not_ready'));
        }
        return view('master.documents.show', compact('document'));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        return view('master.documents.edit', compact('document'));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentsRequest $request, Document $document)
    {
        $document->update([
            'title_' . lang() => $request->title,
            'text' => $request->text,
            'ready_' . lang() => $request->ready == 1 ? 1 : 0,
        ]);

        if ($request->has('view')) {
            return redirect("/documents/$document->id")->withSuccess(trans('documents.saved'));
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
        Document::find($id)->delete();

        return redirect('/master/documents')->withSuccess(
            trans('documents.doc_has_been_deleted')
        );
    }
}
