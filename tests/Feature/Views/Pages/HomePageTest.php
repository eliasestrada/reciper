<?php

namespace Tests\Feature\Views\Pages;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HomePageTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test for home page. View: resources/views/pages/home
	 * @return void
	 * @test
	 */
	public function authUserCanSeeHomePage() : void
    {
		$user = User::find(factory(User::class)->create()->id);

		$this->actingAs($user)
			->get('/')
			->assertOk()
			->assertViewIs('pages.home');
	}

	/**
	 * Test for home page. View: resources/views/pages/home
	 * @return void
	 * @test
	 */
    public function guestCanSeeHomePage() : void
    {
		$this->get('/')
			->assertOk()
			->assertViewIs('pages.home');
	}
}
