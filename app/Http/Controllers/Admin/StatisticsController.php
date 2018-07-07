<?php

namespace App\Http\Controllers\Admin;

use App\Models\Recipe;
use App\Models\Visitor;
use Eseath\SxGeo\SxGeo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $visitors = Visitor::latest()->simplePaginate(40);
		$sxgeo = new SxGeo(storage_path().'/geo/SxGeoCity.dat');
        $allrecipes = Recipe::count();
        $allvisitors = Visitor::distinct('ip')->count();

		return view('admin.statistics.index', compact(
			'sxgeo', 'visitors', 'allrecipes', 'allvisitors'
		));
    }
}
