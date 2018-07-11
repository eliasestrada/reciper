<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserCanSeePages extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test view views/users/other/my-recipes
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
	 * Test view views/users/show
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
	 * Test view views/users/index
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

	/**
	 * Test view views/settings/general
	 * @return void
	 * @test
	 */
	public function authUserCanSeeSettingsGeneralPage() : void
    {
		$user = User::find(factory(User::class)->create()->id);

		$this->actingAs($user)
			->get('/settings/general')
			->assertSuccessful()
			->assertViewIs('settings.general');
	}

	/**
	 * Test view views/settings/photo
	 * @return void
	 * @test
	 */
	public function authUserCanSeeSettingsPhotoPage() : void
    {
		$user = User::find(factory(User::class)->create()->id);

		$this->actingAs($user)
			->get('/settings/photo')
			->assertSuccessful()
			->assertViewIs('settings.photo');
	}

	/**
	 * Test view views/recipes/create
	 * @return void
	 * @test
	 */
	public function authUserCanSeeRecipesCreatePage() : void
    {
		$user = User::find(factory(User::class)->create()->id);
	
		$this->actingAs($user)
			->get('/recipes/create')
			->assertSuccessful()
			->assertViewIs('recipes.create');
	}
}
