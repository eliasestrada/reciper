<?php

namespace App\Http\Controllers\Admin;

use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentsRequest;

class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function index()
	{
		return view('admin.documents.index', [
			'document' => Document::get()
		]);
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.documents.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentsRequest $request)
    {
        $doc = Document::create([
			'title_' . locale() => $request->title,
			'text_' . locale() => $request->text
		]);

		return redirect('/admin/documents/' . $doc->id);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        return view('admin.documents.show', compact('document'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        return view('admin.documents.edit', compact('document'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentsRequest $request, Document $document)
    {
        $document->update([
			'title_' . locale() => $request->title,
			'text_' . locale() => $request->text
		]);

		return $request->has('view')
			? redirect('/admin/documents/' . $document->id)->withSuccess(trans('documents.saved'))
			: back()->withSuccess(trans('documents.saved'));
    }

    /**
     * Remove the specified resource from storage.
     *
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
