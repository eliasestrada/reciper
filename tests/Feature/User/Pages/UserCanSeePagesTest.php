<?php

namespace Tests\Feature\User\Pages;

use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserCanSeePages extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test for home page. View: resources/views/pages/home
	 * @return void
	 * @test
	 */
	public function authUserCanSeeHomePage() : void
    {
		$user = User::find(factory(User::class)->create()->id);

		$this->actingAs($user)
			->get('/')
			->assertSuccessful()
			->assertViewIs('pages.home');
	}
}
