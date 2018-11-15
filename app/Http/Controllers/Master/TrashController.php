<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Help;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrashController extends Controller
{
    /**
     * Show view with all trashed data
     *
     * @return Illuminate\View\View
     */
    public function index(): View
    {
        $trash = Help::onlyTrashed()->paginate(40);
        return view('master.trash.index', compact('trash'));
    }

    /**
     * Restore material
     *
     * @param Request $request
     * @param int $id
     */
    public function update(Request $request, int $id)
    {
        if ($request->table === 'help') {
            Help::withTrashed()->whereId($id)->restore();

            cache()->forget('help');
            cache()->forget('help_categories');

            return redirect("/help/{$id}")
                ->withSuccess(trans('messages.trash_restored'));
        }

        return back()->withError(trans('messages.not_allowed'));
    }

    /**
     * Force deletes all trash
     *
     * @param Request $request
     * @param int $id
     */
    public function destroy(Request $request, int $id)
    {
        if ($request->table === 'help') {
            Help::withTrashed()->whereId($id)->forceDelete();

            return redirect('/master/trash')
                ->withSuccess(trans('messages.trash_deleted'));
        }
        return back()->withError(trans('messages.not_allowed'));
    }
}
