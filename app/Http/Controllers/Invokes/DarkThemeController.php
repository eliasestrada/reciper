<?php

namespace App\Http\Controllers\Invokes;

use App\Http\Controllers\Controller;
use Cookie;
use Illuminate\Http\Request;

class DarkThemeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $state)
    {
        if ($state == 1) {
            Cookie::queue('r_dark_theme', 1, 218400);
        } else {
            Cookie::queue('r_dark_theme', 0, -1);
        }
    }
}
