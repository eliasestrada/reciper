<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recipe;

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
        $unapproved = Recipe::where([
            'approved_' . lang() => 0,
            'ready_' . lang() => 1,
        ])->oldest()->paginate(10);

        return view('admin.checklist.index', compact('unapproved'));
    }
}
