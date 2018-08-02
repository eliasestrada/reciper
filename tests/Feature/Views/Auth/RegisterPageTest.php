<?php

namespace Tests\Feature\Views\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterPageTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test for register page. View: resources/views/auth/register
	 * @return void
	 * @test
	 */
	public function userCannotSeeRegisterPage() : void
    {
		$this->actingAs(factory(User::class)->make())
			->get('/register')
			->assertRedirect('/dashboard')
			->assertRedirect(action('DashboardController@index'));
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
