<?php

namespace Tests\Feature\Responses;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GuestCannotSeePagesTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test view views/user/my-recipes
	 * @return void
	 */
    public function testGuestCannotSeeMyRecipesPage() : void
    {
		$this->get('/users/other/my-recipes')
			->assertRedirect('/login');
	}
}
