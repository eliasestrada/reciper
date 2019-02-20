<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(): RedirectResponse
    {
        return auth()->check()
            ? redirect('users/' . user()->username)
            : redirect('/');
    }
}
