<?php

namespace Tests\Feature\Guest;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GuestCannotSeePagesTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test view views/user/my-recipes
	 * @return void
	 * @test
	 */
    public function guestCannotSeeMyRecipesPage() : void
    {
		$this->get('/users/other/my-recipes')
			->assertRedirect('/login');
	}
}
