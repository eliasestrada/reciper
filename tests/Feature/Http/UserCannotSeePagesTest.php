<?php

namespace Tests\Feature\Responses;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserCannotSeePagesTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test view views/auth/login
	 * @return void
	 */
	public function testAuthUserCannotSeeLoginPage() : void
    {
		$user = factory(User::class)->make();

		$this->actingAs($user)
			->get('/login')
        	->assertRedirect('/dashboard');
    }
}
