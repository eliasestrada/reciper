<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;

class DashboardController extends Controller
{

    // Create a new controller instance.
    public function __construct()
    {
        $this->middleware('auth');
    }

    // INDEX
    // Show the application dashboard.
    public function index()
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);

        // Count recipes and visits
        $allrecipes = DB::table('recipes')->count();

        return view('dashboard')->withRecipes($user->recipes)
                                ->withAllrecipes($allrecipes);
    }
}
