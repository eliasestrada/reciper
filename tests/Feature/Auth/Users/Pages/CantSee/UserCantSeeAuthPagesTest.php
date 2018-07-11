<?php

namespace Tests\Feature\Auth\Users\Pages\CantSee;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserCantSeeAuthPagesTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test for login page. View: resources/views/auth/login
	 * @return void
	 * @test
	 */
	public function userCantSeeLoginPage() : void
    {
		$this->actingAs(factory(User::class)->make())
			->get('/login')
        	->assertRedirect('/dashboard')
        	->assertRedirect(action('DashboardController@index'));
	}

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
}
