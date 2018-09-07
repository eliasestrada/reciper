<?php

namespace App\Http\Controllers\Admin;

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
        return view('admin.documents.index', [
            'ready_docs' => Document::query()->ready(1)->paginate(20)->onEachSide(1),
            'unready_docs' => Document::query()->ready(0)->paginate(20)->onEachSide(1),
        ]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.documents.create');
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

        return redirect("/admin/documents/$doc->id");
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        return view('admin.documents.show', compact('document'));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        return view('admin.documents.edit', compact('document'));
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
            return redirect("/admin/documents/$document->id")->withSuccess(trans('documents.saved'));
        }
        return $request->ready == 0
        ? back()->withSuccess(trans('documents.saved'))
        : redirect("/admin/documents/$document->id")->withSuccess(trans('documents.published'));
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Check for correct user
        if (!user()->isAdmin()) {
            return redirect('/')->withError(
                trans('admin.only_admin_can_delete')
            );
        }
        Document::find($id)->delete();

        return redirect('/admin/documents')->withSuccess(
            trans('documents.doc_has_been_deleted')
        );
    }
}
