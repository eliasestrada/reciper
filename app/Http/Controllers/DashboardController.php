<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    // INDEX
    public function index()
    {
        $recipes = DB::table('recipes')
                ->where('user_id', auth()->user()->id)
                ->latest()
                ->paginate(10);

        $unapproved = DB::table('recipes')
                ->where([['approved', '=', 0], ['ready', '=', 1]])
                ->oldest()
                ->paginate(10);

        // Count recipes and visits
        $allrecipes = DB::table('recipes')
                ->count();
        $allvisits = DB::table('visitor_registry')
                ->count();
        $allclicks = DB::table('visitor_registry')
                ->sum('clicks');
        $allunapproved = DB::table('recipes')
                ->where([['approved', 0], ['ready', 1]])
                ->count();

        if (auth()->user()->author !== 1 && auth()->user()->admin !== 1) {
                return redirect('/recipes')
                        ->with('success', 'Вы не имеете права посещать эту страницу.');
        }

        return view('dashboard')
                ->withRecipes($recipes)
                ->withAllrecipes($allrecipes)
                ->withAllvisits($allvisits)
                ->withAllclicks($allclicks)
                ->withAllunapproved($allunapproved)
                ->withUnapproved($unapproved);
    }

    public function closeNotification() {

        DB::table('users')
                ->where([['id', auth()->user()->id], ['admin', 1]])
                ->update(['notif' => 0]);

        return back();
    }
}
