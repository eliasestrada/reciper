<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Recipe;
use App\Models\Visitor;
use Eseath\SxGeo\SxGeo;
use App\Models\Feedback;

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

		return view('admin.checklist')->withUnapproved($unapproved);
	}


	public function visitors()
	{
		$visitors = Visitor::latest()->simplePaginate(40);
		$sxgeo = new SxGeo(storage_path().'/geo/SxGeoCity.dat');
        $allrecipes = Recipe::count();
        $allvisitors = Visitor::distinct('ip')->count();

		return view('admin.statistic')->with(compact(
			'sxgeo', 'visitors', 'allrecipes', 'allvisitors'
		));
	}


	public function feedback()
    {
		// Mark that user saw these messages
		User::whereId(user()->id)->update([
			'contact_check' => NOW()
		]);

		return view('admin.feedback')->withFeedback(Feedback::paginate(40));
	}

	/**
	 * @param integer $id
	 */
	public function feedbackDestroy($id)
	{
        // Check for correct user
        if (!user()->isAdmin()) {
            return redirect('/feedback')->withError(
				trans('admin.only_admin_can_delete')
			);
        }
		Feedback::find($id)->delete();

        return redirect('/admin/feedback')->withSuccess(
			trans('admin.feedback_has_been_deleted')
		);
	}
}
