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
            $help = cache()->remember('help', 10, function () {
                return Help::selectBasic()->orderBy('title')->get()->toArray();
            });

            $help_categories = cache()->remember('help_categories', 10, function () {
                return HelpCategory::selectBasic()->get()->toArray();
            });

            return view('help.index', compact('help', 'help_categories'));
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return view('help.index', ['help' => [], 'help_categories' => []]);
        }
    }

    /**
     * @param Help $help
     */public function show(Help $help)
    {
        return view('help.show', compact('help'));
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

        $this->forgetCache();

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

        $this->forgetCache();

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
        $this->forgetCache();

        return redirect('/help')->withSuccess(trans('help.help_deleted'));
    }

    /**
     * Function helper
     *
     * @return void
     */
    public function forgetCache(): void
    {
        cache()->forget('help');
        cache()->forget('help_categories');
    }
}
