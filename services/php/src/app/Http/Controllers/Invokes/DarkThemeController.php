<?php

namespace App\Http\Controllers\Invokes;

use Cookie;
use App\Http\Controllers\Controller;

class DarkThemeController extends Controller
{
    /**
     * Except XHR request from javscript and returns cookie
     *
     * @param int|null $state
     */
    public function __invoke(?int $state = null)
    {
        return $state == 1
            ? Cookie::queue('r_dark_theme', 1, 218400)
            : Cookie::queue('r_dark_theme', 0, -1);
    }
}
