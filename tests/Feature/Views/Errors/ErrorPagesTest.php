<?php

namespace Tests\Feature\Views\Errors;

use Tests\TestCase;

class Errors404PageTest extends TestCase
{
    /**
     * @author Cho
     * @test
     */
    public function page_404_not_found_shows_up(): void
    {
        $this->get('/random-address')->assertSee(trans('errors.404_title'));
    }

    /**
     * @author Cho
     * @test
     */
    public function page_503_be_right_back_shows_up(): void
    {
        $this->artisan('down');
        $this->get('/')->assertSee(trans('errors.503_title'));
        $this->artisan('up');
        $this->get('/')->assertDontSee(trans('errors.503_title'));
    }
}
