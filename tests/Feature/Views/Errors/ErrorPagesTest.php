<?php

namespace Tests\Feature\Views\Errors;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class Errors404PageTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * @test
	 * @return void
	 */
	public function page404NotFoundShowsUp() : void
	{
		$this->get('/random-address')
			->assertSee(trans('errors.404_title'));
	}

	/**
	 * @test
	 * @return void
	 */
	public function page503BeRightBackShowsUp() : void
	{
		$this->artisan('down');
		$this->get('/')->assertSee(trans('errors.503_title'));
		$this->artisan('up');
		$this->get('/')->assertDontSee(trans('errors.503_title'));
	}
}
