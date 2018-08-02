<?php

namespace Tests\Feature\Guest\Pages\CanSee;

use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GuestCanSeeAuthPagesTest extends TestCase
{
	use DatabaseTransactions;

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
