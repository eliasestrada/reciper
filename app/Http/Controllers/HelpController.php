<?php

namespace App\Http\Controllers;

use App\Models\Help;
use App\Models\HelpCategory;
use Illuminate\Database\QueryException;

class HelpController extends Controller
{
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
}
