<?php

namespace App\Http\Controllers;

use App\Models\Help;

class HelpController extends Controller
{
    public function index()
    {
        return view('help.index', [
            'help' => Help::get(['id', 'title_' . lang()]),
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
