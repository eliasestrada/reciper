<?php

namespace Tests\Feature\Views\Errors;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class Errors404PageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * resources/views/errors/404.blade.php
     * @test
     * @return void
     */
    public function page404NotFoundShowsUp(): void
    {
        $this->get('/random-address')
            ->assertSee(trans('errors.404_title'));
    }

    /**
     * resources/views/errors/503.blade.php
     * @test
     * @return void
     */
    public function page503BeRightBackShowsUp(): void
    {
        $this->artisan('down');
        $this->get('/')->assertSee(trans('errors.503_title'));
        $this->artisan('up');
        $this->get('/')->assertDontSee(trans('errors.503_title'));
    }
}
