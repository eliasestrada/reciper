<?php

namespace App\Http\Controllers;

use App\Models\Help;
use App\Repos\HelpCategoryRepo;
use App\Repos\HelpRepo;
use Illuminate\Database\QueryException;
use Illuminate\View\View;

class HelpController extends Controller
{
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
}
