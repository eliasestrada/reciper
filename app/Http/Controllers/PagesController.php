<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home() {
        $title = "Рецепты";
        return view('pages.home')->with('title', $title);
    }

    public function search() {
        return view('pages.search');
    }
}
