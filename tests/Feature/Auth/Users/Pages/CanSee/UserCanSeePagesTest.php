<?php

namespace Tests\Feature\Auth\Users\Pages\CanSee;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserCanSeePages extends TestCase
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
	 * Test for search page. View: resources/views/pages/search
	 * @return void
	 * @test
	 */
	public function authUserCanSeeSearchPage() : void
    {
		$user = User::find(factory(User::class)->create()->id);

		$this->actingAs($user)
			->get('/search')
			->assertOk()
			->assertViewIs('pages.search');
	}

	/**
	 * Test for contact page. View: resources/views/pages/contact
	 * @return void
	 * @test
	 */
	public function authUserCanSeeContactPage() : void
    {
		$user = User::find(factory(User::class)->create()->id);

		$this->actingAs($user)
			->get('/contact')
			->assertOk()
			->assertViewIs('pages.contact');
	}
}
