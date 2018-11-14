<?php

namespace App\Http\Controllers;

use App\Http\Requests\Help\HelpStoreRequest;
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
     */
    public function show(Help $help)
    {
        return view('help.show', compact('help'));
    }

    /**
     * Show create page
     */
    public function create()
    {
        return view('help.create', compact('help'));
    }

    /**
     * Store data in database
     *
     * @param HelpStoreRequest $request
     */
    public function store(HelpStoreRequest $request)
    {
        Help::create([
            'title_' . LANG() => request('title'),
            'text_' . LANG() => request('text'),
            'help_category_id' => request('category'),
        ]);

        return redirect('/help')->withSuccess(
            trans('help.help_message_is_created')
        );
    }
}
