<?php

namespace App\Http\Controllers;

use App\Models\Help;
use App\Models\HelpCategory;

class HelpController extends Controller
{
    public function index()
    {
        return view('help.index', [
            'help' => Help::orderBy('title_' . LANG)->get([
                'id', 'help_category_id', 'title_' . LANG,
            ]),
            'help_categories' => HelpCategory::get(),
        ]);
    }

    /**
     * @param Help $help
     */
    public function show(Help $help)
    {
        return view('help.show', compact('help'));
    }
}
