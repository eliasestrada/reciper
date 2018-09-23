<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Visitor;

class StatisticsController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $visitors = Visitor::latest()->paginate(40)->onEachSide(1);
        $all_recipes = Recipe::count();
        $all_visitors = Visitor::distinct('ip')->count();

        return view('statistics.index', compact(
            'visitors', 'all_recipes', 'all_visitors'
        ));
    }
}
