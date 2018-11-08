<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Visitor;

class VisitorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.visitors.index', [
            'visitors' => Visitor::withCount('views')
                ->withCount('likes')
                ->orderBy('views_count', 'desc')
                ->paginate(50)
                ->onEachSide(1),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function show(Visitor $visitor)
    {
        return view('master.visitors.show', compact('visitor'));
    }
}
