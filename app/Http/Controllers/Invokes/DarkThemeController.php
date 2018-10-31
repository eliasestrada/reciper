<?php

namespace App\Http\Controllers\Invokes;

use App\Http\Controllers\Controller;
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
            cache()->forever('dark-theme', 'dark-theme');
        } else {
            cache()->forget('dark-theme');
        }
    }
}
