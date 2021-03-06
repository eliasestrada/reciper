<?php

namespace App\Http\Controllers;

use App\Repos\HelpRepo;
use Illuminate\View\View;
use App\Repos\HelpCategoryRepo;

class HelpController extends Controller
{
    /**
     * @var \App\Repos\HelpRepo
     */
    private $help_repo;

    /**
     * @var \App\Repos\HelpCategoryRepo
     */
    private $help_category_repo;

    /**
     * @param \App\Repos\HelpRepo $help_repo
     * @param \App\Repos\HelpCategoryRepo $help_category_repo
     * @return void
     */
    public function __construct(HelpRepo $help_repo, HelpCategoryRepo $help_category_repo)
    {
        $this->help_repo = $help_repo;
        $this->help_category_repo = $help_category_repo;
    }

    /**
     * @return \Illuminate\Http\View
     */
    public function index(): View
    {
        return view('help.index', [
            'help_list' => $this->help_repo->getCache(),
            'help_categories' => $this->help_category_repo->getCache(),
        ]);
    }

    /**
     * Show single help material with sidebar navigation
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show(int $id): View
    {
        return view('help.show', [
            'help' => $this->help_repo->find($id),
            'help_list' => $this->help_repo->getCache(),
            'help_categories' => $this->help_category_repo->getCache(),
        ]);
    }
}
