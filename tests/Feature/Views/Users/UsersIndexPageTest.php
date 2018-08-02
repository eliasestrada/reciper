<?php

namespace Tests\Feature\Views\Users;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersIndexPageTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test for users page. View: resources/views/users/index
	 * @return void
	 * @test
	 */
	public function authUserCanSeeUsersIndexPage() : void
    {
		$user = User::find(factory(User::class)->create()->id);

		$this->actingAs($user)
			->get('/users')
			->assertOk()
			->assertViewIs('users.index');
	}

	/**
	 * Test for users page. View: resources/views/users/index
	 * @return void
	 * @test
	 */
	public function guestCanSeeUsersIndexPage() : void
	{
		$this->get('/users')
			->assertOk()
			->assertViewIs('users.index');
	}
}
