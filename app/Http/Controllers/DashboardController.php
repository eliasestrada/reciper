<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function __construct()
    {
		$this->middleware('author');
	}

    public function index()
    {
		return redirect('users/' . user()->id);
    }
}
