<?php

namespace App\Http\Controllers;

use App\Models\Help;
use App\Models\HelpCategory;

class HelpController extends Controller
{
    public function index()
    {
        return view('help.index', [
            'help' => Help::selectBasic()->orderBy('title')->get(),
            'help_categories' => HelpCategory::selectBasic()->get(),
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
