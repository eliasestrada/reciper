<?php

namespace Tests\Feature\Guest\Pages\CanSee;

use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GuestCanSeePagesTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test for search page. View: resources/views/pages/search
	 * @return void
	 * @test
	 */
    public function guestCanSeeSearchPage() : void
    {
		$this->get('/search')
			->assertOk()
			->assertViewIs('pages.search');
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

	/**
	 * Test for contact page. View: resources/views/pages/contact
	 * @return void
	 * @test
	 */
	public function guestCanSeeContactPage() : void
    {
		$this->get('/contact')
			->assertOk()
			->assertViewIs('pages.contact');
	}

	/**
	 * Test for login page. View: resources/views/auth/login
	 * @return void
	 * @test
	 */
	public function guestCanSeeLoginPage() : void
	{
		$this->get('/login')
        	->assertOk()
        	->assertViewIs('auth.login');
	}

	/**
	 * Test for register page. View: resources/views/auth/register
	 * @return void
	 * @test
	 */
	public function guestCanSeeRegisterPage() : void
	{
		$this->get('/register')
			->assertOk()
			->assertViewIs('auth.register');
	}
}
