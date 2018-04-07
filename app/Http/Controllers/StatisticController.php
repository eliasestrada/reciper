<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Eseath\SxGeo\SxGeo;

class StatisticController extends Controller
{
	public function __construct()
    {
        $this->middleware('author');
	}

	/* VISITORS
	====================== */

    public function visitors() {

		$visitors = DB::table('visitor_registry')
				->orderBy('clicks', 'desc')
				->paginate(20);

		$sxgeo = new SxGeo(storage_path().'/geo/SxGeoCity.dat');

		// Count recipes and visits
        $allrecipes = DB::table('recipes')->count();
        $allvisits = DB::table('visitor_registry')->count();
        $allclicks = DB::table('visitor_registry')->sum('clicks');

		return view('statistic')->with([
			'sxgeo' => $sxgeo,
			'visitors' => $visitors,
			'allrecipes' => $allrecipes,
			'allvisits' => $allvisits,
			'allclicks' => $allclicks
		]);
	}
}