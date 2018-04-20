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


    public function visitors() {

		$visitors = DB::table('visitor_registry')
				->orderBy('clicks', 'desc')
				->simplePaginate(20);

		$sxgeo = new SxGeo(storage_path().'/geo/SxGeoCity.dat');

		// Count recipes and visits
        $allrecipes = DB::table('recipes')->count();
        $allclicks = DB::table('visitor_registry')->sum('clicks');

		return view('statistic')->with([
			'sxgeo' => $sxgeo,
			'visitors' => $visitors,
			'allrecipes' => $allrecipes,
			'allclicks' => $allclicks
		]);
	}
}