<?php

namespace App\Http\Controllers;

use App\Http\Requests\HelpRequest;
use App\Models\Help;
use App\Models\HelpCategory;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin')->except(['index', 'show']);
    }

    public function index()
    {
        try {
            return view('help.index', [
                'help_list' => $this->getHelpList(),
                'help_categories' => $this->getHelpCategories(),
            ]);
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return view('help.index');
        }
    }

    /**
     * @param Help $help
     */
    public function show(Help $help)
    {
        try {
            return view('help.show', [
                'help' => $help,
                'help_list' => $this->getHelpList(),
                'help_categories' => $this->getHelpCategories(),
            ]);
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return view('help.index');
        }
    }

    /**
     * Show create page
     */
    public function create()
    {
        $categories = HelpCategory::select('id', 'title_' . LANG() . ' as title')->get();
        return view('help.create', compact('categories'));
    }

    /**
     * Store data in database
     *
     * @param HelpRequest $request
     */
    public function store(HelpRequest $request)
    {
        Help::create([
            'title_' . LANG() => request('title'),
            'text_' . LANG() => request('text'),
            'help_category_id' => request('category'),
        ]);

        cache()->forget('help');
        cache()->forget('help_categories');

        return redirect('/help')->withSuccess(
            trans('help.help_message_is_created')
        );
    }

    /**
     * Show edit page
     */
    public function edit(Help $help)
    {
        $categories = HelpCategory::select('id', 'title_' . LANG() . ' as title')->get();
        return view('help.edit', compact('categories', 'help'));
    }

    /**
     * Update existing help material
     *
     * @param HelpRequest $request
     * @param Help $help
     */
    public function update(HelpRequest $request, Help $help)
    {
        $help->update([
            'title_' . LANG() => request('title'),
            'text_' . LANG() => request('text'),
            'help_category_id' => request('category'),
        ]);

        cache()->forget('help');
        cache()->forget('help_categories');

        return redirect("/help/{$help->id}/edit")
            ->withSuccess(trans('help.help_updated'));
    }

    /**
     * Delete particular help material
     *
     * @param Help $help
     */
    public function destroy(Help $help)
    {
        $help->delete();

        cache()->forget('help');
        cache()->forget('help_categories');
        cache()->forget('trash_notif');

        return redirect('/help')->withSuccess(trans('help.help_deleted'));
    }

    public function getHelpList()
    {
        return cache()->remember('help_list', 10, function () {
            return Help::selectBasic()->orderBy('title')->get()->toArray();
        });
    }

    public function getHelpCategories()
    {
        return cache()->remember('help_categories', 10, function () {
            return HelpCategory::selectBasic()->get()->toArray();
        });
    }
}
