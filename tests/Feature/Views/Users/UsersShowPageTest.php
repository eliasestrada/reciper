<?php

namespace Tests\Feature\Views\Users;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersShowPageTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test for profile page. View: resources/view views/users/show
	 * @return void
	 * @test
	 */
	public function authUserCanSeeUsersShowPage() : void
    {
		$user = User::find(factory(User::class)->create()->id);

		$this->actingAs($user)
			->get('/users/' . $user->id)
			->assertOk()
			->assertViewIs('users.show');
	}

	/**
	 * Test for user profile page. View: resources/views/users/show
	 * @return void
	 * @test
	 */
	public function guestCanSeeUsersShowPage() : void
	{
		$user = factory(User::class)->create();

		$this->get('/users/' . $user->id)
			->assertOk()
			->assertViewIs('users.show');
	}
}
