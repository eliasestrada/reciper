<?php

namespace Tests\Feature\Guest\Pages\CanSee;

use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GuestCanSeeUsersPagesTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test for users page. View: resources/views/users/index
	 * @return void
	 * @test
	 */
	public function guestCanSeeAllRegisteredUsers() : void
	{
		$this->get('/users')
			->assertSuccessful()
			->assertViewIs('users.index');
	}

	/**
	 * Test for user profile page. View: resources/views/users/show
	 * @return void
	 * @test
	 */
	public function guestCanSeeRegisteredUser() : void
	{
		$user = factory(User::class)->create();

		$this->get('/users/' . $user->id)
			->assertSuccessful()
			->assertViewIs('users.show');
	}
}
