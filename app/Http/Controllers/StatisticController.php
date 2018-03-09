<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Eseath\SxGeo\SxGeo;

class StatisticController extends Controller
{
    public function visitors() {

		$visitors = DB::table('visitor_registry')
				->orderBy('clicks', 'desc')
				->paginate(50);

		$cities = [];
		$sxgeo = new SxGeo(storage_path().'/geo/SxGeoCity.dat');

		foreach ($visitors as $visitor) {
			$cities[] = $sxgeo->getCityFull($visitor->ip);
		}

		//$full_info  = $sxgeo->getCityFull($ip);
		//$visitors = $sxgeo->get($ip);

		return view('statistic')
				->withCities($cities)
				->withVisitors($visitors);
	}
}