<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\VisitorsRequest;
use App\Models\Ban;
use App\Models\Visitor;
use Illuminate\Http\Request;

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
            'visitors' => Visitor::withCount('views')->orderBy('views_count', 'desc')->paginate(50)->onEachSide(1),
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

    /**
     * Ban visitor
     * @param Request $request
     * @param Visitor $visitor
     * @return void
     */
    public function update(VisitorsRequest $request, Visitor $visitor)
    {
        // Check if visitor is already banned
        if (Ban::whereVisitorId($visitor->id)->exists()) {
            return back()->withError(trans('visitors.visitor_already_banned'));
        }

        if ($visitor->id != 1) {
            Ban::banVisitor($visitor->id, $request->days, $request->message);
            return back()->withSuccess(trans('visitors.visitor_banned', ['days' => $request->days]));
        }
        return back();
    }

    /**
     * Unban visitor
     * @param Visitor $visitor
     */
    public function destroy(Visitor $visitor)
    {
        $visitor->ban()->delete();
        return back()->withSuccess(trans('visitors.visitor_unbanned'));
    }
}
