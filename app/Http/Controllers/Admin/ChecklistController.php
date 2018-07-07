<?php

namespace App\Http\Controllers\Admin;

use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChecklistController extends Controller
{
    /**
	 * Checklist shows all recipes that need to be approved
	 * by administration
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unapproved = Recipe::where('approved_'.locale(), 0)
			->where('ready_'.locale(), 1)
			->oldest()
			->paginate(10);

		return view('admin.checklist.index', compact('unapproved'));
	}
}
