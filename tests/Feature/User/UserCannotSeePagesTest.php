<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserCannotSeePagesTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test view views/auth/login
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
	 * Test view views/auth/register
	 * @return void
	 */
	public function testAuthUserCannotSeeRegisterPage() : void
    {
		$this->actingAs(factory(User::class)->make())
			->get('/register')
        	->assertRedirect('/dashboard');
    }
}
