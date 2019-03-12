<?php

namespace Tests\Unit\Controllers\Invokes;

use Tests\TestCase;

class DarkThemeControllerTest extends TestCase
{
    /**
     * @test
     */
    public function user_got_cookie_after_dark_theme_switcher_request_with_state_of_1(): void
    {
        cookie()->forget('r_dark_theme');
        $this->get('invokes/dark-theme-switcher/1')->assertCookie('r_dark_theme');
        cookie()->forget('r_dark_theme');
    }
}
