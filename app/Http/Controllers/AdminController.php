<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Recipe;
use Eseath\SxGeo\SxGeo;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
	 * Checklist shows all recipes that need to be approved
	 * by administration
	 */
	public function checklist()
	{
		$unapproved = Recipe::whereApproved(0)
				->whereReady(1)
				->oldest()
				->paginate(10);

		return view('admin.checklist')->withUnapproved($unapproved);
	}


	public function visitors()
	{
		$visitors = DB::table('visitor_registry')
				->orderBy('clicks', 'desc')
				->simplePaginate(40);

		$sxgeo = new SxGeo(storage_path().'/geo/SxGeoCity.dat');

		// Count recipes and visits
        $allrecipes = DB::table('recipes')->count();
        $allvisitors = DB::table('visitor_registry')->distinct('ip')->count();
        $allclicks  = DB::table('visitor_registry')->sum('clicks');

		return view('admin.statistic')->with(compact(
			'sxgeo', 'visitors', 'allrecipes', 'allclicks', 'allvisitors'
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


	public function feedbackDestroy($id)
	{
        // Check for correct user
        if (!user()->isAdmin()) {
            return redirect('/feedback')->withError(
				'Только админ может удалять эти сообщения!'
			);
        }
		Feedback::find($id)->delete();

        return redirect('/admin/feedback')->withSuccess('Отзыв успешно удален');
	}
}
