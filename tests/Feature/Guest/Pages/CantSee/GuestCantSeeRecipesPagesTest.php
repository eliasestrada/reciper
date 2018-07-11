<?php

namespace Tests\Feature\Guest\Pages\CantSee;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GuestCantSeeRecipesPagesTest extends TestCase
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
}
