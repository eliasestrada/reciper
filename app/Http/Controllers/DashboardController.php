<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class DashboardController extends Controller
{

    // Create a new controller instance.
    public function __construct()
    {
        $this->middleware('auth');
    }


    // Show the application dashboard.
    public function index()
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        return view('dashboard')->with('recipes', $user->recipes);

    }
}
