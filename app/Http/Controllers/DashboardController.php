<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        return auth()->check()
        ? redirect('users/' . user()->username)
        : redirect('/');
    }
}
