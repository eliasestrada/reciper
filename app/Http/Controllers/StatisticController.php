<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Eseath\SxGeo\SxGeo;

class StatisticController extends Controller
{
	public function __construct()
    {
        $this->middleware('admin');
	}

	/* VISITORS
	====================== */

    public function visitors() {

		$visitors = DB::table('visitor_registry')
				->orderBy('clicks', 'desc')
				->paginate(40);

		$sxgeo = new SxGeo(storage_path().'/geo/SxGeoCity.dat');

		return view('statistic')
				->withSxgeo($sxgeo)
				->withVisitors($visitors);
	}
}