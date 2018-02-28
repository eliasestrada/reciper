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
        $admin_recipes = DB::table('recipes')->where('approved', 0)->latest()->paginate(1);
        //  TODO:

        // Count recipes and visits
        $allrecipes = DB::table('recipes')->count();
        $allvisits = DB::table('visitor_registry')->count();
        $allclicks = DB::table('visitor_registry')->sum('clicks');

        return view('dashboard')
                ->withRecipes($user->recipes)
                ->withAllrecipes($allrecipes)
                ->withAllvisits($allvisits)
                ->withAllclicks($allclicks)
                ->with('admin_recipes', $admin_recipes);
    }
}
