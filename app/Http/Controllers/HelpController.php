<?php

namespace App\Http\Controllers;

use App\Models\Help;
use App\Repos\HelpCategoryRepo;
use Illuminate\View\View;

class HelpController extends Controller
{
    /**
     * @return \Illuminate\Http\View
     */
    public function index(HelpCategoryRepo $help_category_repo): View
    {
        return view('help.index', [
            'help_list' => $help_category_repo->getCache(),
            'help_categories' => $help_category_repo->getCache(),
        ]);
    }

    /**
     * Show single help material with sidebar navigation
     *
     * @param \App\Models\Help $help
     * @return \Illuminate\View\View
     */
    public function show(Help $help, HelpCategoryRepo $help_category_repo): View
    {
        return view('help.show', [
            'help' => $help,
            'help_list' => $help_category_repo->getCache(),
            'help_categories' => $help_category_repo->getCache(),
        ]);
    }
}
