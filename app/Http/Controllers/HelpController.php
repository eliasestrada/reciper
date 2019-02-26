<?php

namespace App\Http\Controllers;

use App\Models\Help;
use App\Repos\HelpRepo;
use Illuminate\View\View;
use App\Repos\HelpCategoryRepo;

class HelpController extends Controller
{
    /**
     * @return \Illuminate\Http\View
     */
    public function index(HelpRepo $help_repo, HelpCategoryRepo $help_category_repo): View
    {
        return view('help.index', [
            'help_list' => $help_repo->getCache(),
            'help_categories' => $help_category_repo->getCache(),
        ]);
    }

    /**
     * Show single help material with sidebar navigation
     *
     * @param \App\Models\Help $help
     * @return \Illuminate\View\View
     */
    public function show(Help $help, HelpRepo $help_repo, HelpCategoryRepo $help_category_repo): View
    {
        return view('help.show', [
            'help' => $help,
            'help_list' => $help_repo->getCache(),
            'help_categories' => $help_category_repo->getCache(),
        ]);
    }
}
