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
        $unapproved = Recipe::query()
            ->approved(0)
            ->ready(1)
            ->oldest()
            ->paginate(30)
            ->onEachSide(1);

        return view('admin.checklist.index', compact('unapproved'));
    }
}
