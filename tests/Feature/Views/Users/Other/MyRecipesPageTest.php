<?php

namespace Tests\Feature\Views\Users\Other;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MyRecipesPageTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test for my recipes page. View: resources/views/user/my-recipes
	 * @return void
	 * @test
	 */
    public function guestCantSeeMyRecipesPage() : void
    {
		$this->get('/users/other/my-recipes')
			->assertRedirect('/login');
	}

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
			->assertOk()
			->assertViewIs('users.other.my-recipes');
	}
}
