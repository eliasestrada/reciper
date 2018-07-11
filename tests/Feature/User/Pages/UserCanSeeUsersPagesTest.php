<?php

namespace Tests\Feature\User\Pages;

use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserCanSeeUsersPagesTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test for my recipes page. View: resources/vews/users/other/my-recipes
	 * @return void
	 * @test
	 */
	public function authUserCanSeeMyRecipesPage() : void
    {
		$user = User::find(factory(User::class)->create()->id);

		$this->actingAs($user)
			->get('/users/other/my-recipes')
			->assertSuccessful()
			->assertViewIs('users.other.my-recipes');
	}

	/**
	 * Test for profile page. View: resources/view views/users/show
	 * @return void
	 * @test
	 */
	public function authUserCanSeeProfilePage() : void
    {
		$user = User::find(factory(User::class)->create()->id);

		$this->actingAs($user)
			->get('/users/' . $user->id)
			->assertSuccessful()
			->assertViewIs('users.show');
	}

	/**
	 * Test for users page. View: resources/views/users/index
	 * @return void
	 * @test
	 */
	public function authUserCanSeeUsersPage() : void
    {
		$user = User::find(factory(User::class)->create()->id);

		$this->actingAs($user)
			->get('/users')
			->assertSuccessful()
			->assertViewIs('users.index');
	}
}
