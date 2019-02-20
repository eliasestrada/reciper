<?php

namespace App\Http\Controllers\Invokes;

use App\Http\Controllers\Controller;
use Cookie;

class FontSizeController extends Controller
{
    /**
     * Returns cookie with needed value
     *
     * @param mixed $font_size
     */
    public function __invoke($font_size = null)
    {
        if ($font_size && is_numeric($font_size)) {
            return $font_size <= 0.8 || $font_size >= 1.6
                ? Cookie::queue('r_font_size', $font_size, -1)
                : Cookie::queue('r_font_size', round($font_size, 1), 218400);
        }
    }
}
