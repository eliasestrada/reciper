<?php

namespace App\Http\Controllers\Master;

use App\Models\Help;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class TrashController extends Controller
{
    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('master');
    }

    /**
     * Show view with all trashed data
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $trash = Help::onlyTrashed()->paginate(40);
        return view('master.trash.index', compact('trash'));
    }

    /**
     * Restore material
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        if ($request->table === 'help') {
            Help::withTrashed()->whereId($id)->restore();

            cache()->forget('help');
            cache()->forget('help_categories');
            cache()->forget('trash_notif');

            return redirect("/help/{$id}")->withSuccess(
                trans('messages.trash_restored')
            );
        }

        return back()->withError(trans('messages.not_allowed'));
    }

    /**
     * Force deletes all trash
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, int $id): RedirectResponse
    {
        if ($request->table === 'help') {
            Help::withTrashed()->whereId($id)->forceDelete();

            cache()->forget('trash_notif');

            return redirect('/master/trash')->withSuccess(
                trans('messages.trash_deleted')
            );
        }
        return back()->withError(trans('messages.not_allowed'));
    }
}
