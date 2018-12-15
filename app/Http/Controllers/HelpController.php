<?php

namespace App\Http\Controllers;

use App\Http\Requests\HelpRequest;
use App\Models\Help;
use App\Models\HelpCategory;
use App\Repos\HelpCategoryRepo;
use App\Repos\HelpRepo;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HelpController extends Controller
{
    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin')->except(['index', 'show']);
    }

    /**
     * @return \Illuminate\Http\View
     */
    public function index(): View
    {
        try {
            return view('help.index', [
                'help_list' => HelpRepo::getCache(),
                'help_categories' => HelpCategoryRepo::getCache(),
            ]);
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return view('help.index');
        }
    }

    /**
     * Show single help material with sidebar navigation
     *
     * @param \App\Models\Help $help
     * @return \Illuminate\View\View
     */
    public function show(Help $help): View
    {
        try {
            return view('help.show', [
                'help' => $help,
                'help_list' => HelpRepo::getCache(),
                'help_categories' => HelpCategoryRepo::getCache(),
            ]);
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return view('help.index');
        }
    }

    /**
     * Show create page
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        $categories = HelpCategory
            ::select('id', 'title_' . LANG() . ' as title')
            ->get();

        return view('help.create', compact('categories'));
    }

    /**
     * Store data in database and clean cache
     *
     * @param \App\Http\Requests\HelpRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(HelpRequest $request): RedirectResponse
    {
        HelpRepo::create($request);

        $this->forgetCache();

        return redirect('/help')->withSuccess(
            trans('help.help_message_is_created')
        );
    }

    /**
     * Show edit page
     *
     * @param \App\Models\Help
     * @return \Illuminate\View\View
     */
    public function edit(Help $help): View
    {
        $categories = HelpCategory
            ::select('id', 'title_' . LANG() . ' as title')
            ->get();

        return view('help.edit', compact('categories', 'help'));
    }

    /**
     * Update existing help material
     *
     * @param \App\Http\Requests\HelpRequest $request
     * @param \App\Models\Help $help
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(HelpRequest $request, Help $help): RedirectResponse
    {
        HelpRepo::update($help, $request);

        $this->forgetCache();

        return redirect("/help/{$help->id}/edit")->withSuccess(
            trans('help.help_updated')
        );
    }

    /**
     * Delete particular help material
     *
     * @param \App\Models\Help $help
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Help $help): RedirectResponse
    {
        $help->delete();

        $this->forgetCache();
        cache()->forget('trash_notif');

        return redirect('/help')->withSuccess(trans('help.help_deleted'));
    }

    /**
     * Method helper
     *
     * @return void
     */
    public function forgetCache(): void
    {
        cache()->forget('help_list');
        cache()->forget('help_categories');
    }
}
