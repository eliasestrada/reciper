<?php

namespace App\Http\Controllers\Admin;

use App\Models\Recipe;
use App\Models\Visitor;
use Eseath\SxGeo\SxGeo;

class AdminController extends Controller
{
    /**
	 * Checklist shows all recipes that need to be approved
	 * by administration
	 */
	public function checklist()
	{
		$unapproved = Recipe::where('approved_'.locale(), 0)
			->where('ready_'.locale(), 1)
			->oldest()
			->paginate(10);

		return view('admin.checklist', compact('unapproved'));
	}


	public function visitors()
	{
		$visitors = Visitor::latest()->simplePaginate(40);
		$sxgeo = new SxGeo(storage_path().'/geo/SxGeoCity.dat');
        $allrecipes = Recipe::count();
        $allvisitors = Visitor::distinct('ip')->count();

		return view('admin.statistic', compact(
			'sxgeo', 'visitors', 'allrecipes', 'allvisitors'
		));
	}
}
