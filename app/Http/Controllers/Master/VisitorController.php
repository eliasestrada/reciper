<?php

namespace App\Http\Controllers\Master;

use App\Models\Visitor;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class VisitorController extends Controller
{
    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('master');
    }

    /**
     * Display page with all visitrors
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        return view('master.visitors.index', [
            'visitors' => Visitor::withCount('views')
                ->orderBy('created_at', 'desc')
                ->paginate(50)
                ->onEachSide(1),
        ]);
    }

    /**
     * Display page with single visitor
     *
     * @param \App\Models\Visitor  $visitor
     * @return \Illuminate\View\View
     */
    public function show(Visitor $visitor): View
    {
        return view('master.visitors.show', compact('visitor'));
    }
}
