<?php

namespace Tests\Feature\Responses;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GuestCanViewPagesTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test view views/user/my-recipes
	 * @return void
	 */
    public function testGuestCantSeeMyRecipesPage() : void
    {
		$this->get('/users/other/my-recipes')
        	->assertSuccessful()
        	->assertViewIs('users.other.my-recipes');
	}
}
