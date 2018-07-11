<?php

namespace Tests\Feature\Users\Pages\CannotSee;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserCannotSeeAuthPagesTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test for login page. View: resources/views/auth/login
	 * @return void
	 * @test
	 */
	public function authUserCannotSeeLoginPage() : void
    {
		$this->actingAs(factory(User::class)->make())
			->get('/login')
        	->assertRedirect('/dashboard');
	}

	/**
	 * Test for register page. View: resources/views/auth/register
	 * @return void
	 */
	public function testAuthUserCannotSeeRegisterPage() : void
    {
		$this->actingAs(factory(User::class)->make())
			->get('/register')
        	->assertRedirect('/dashboard');
    }
}
