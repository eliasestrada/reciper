<?php

namespace Tests\Feature\Views\Pages;

use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SearchPageTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * @test
	 * @return void
	 */
	public function serchFormShowsResultsAfterSubmitting() : void
	{
		factory(Recipe::class)->create(['title_' . locale() => 'Recipe for test']);

		$this->get('/search?for=Recipe+for+test')
			->assertOk()
			->assertSeeText('Recipe for test');
	}

	/**
	 * Test for search page. View: resources/views/pages/search
	 * @return void
	 * @test
	 */
    public function guestCanSeeSearchPage() : void
    {
		$this->get('/search')
			->assertOk()
			->assertViewIs('pages.search');
	}

	/**
	 * Test for search page. View: resources/views/pages/search
	 * @return void
	 * @test
	 */
	public function authUserCanSeeSearchPage() : void
    {
		$user = User::find(factory(User::class)->create()->id);

		$this->actingAs($user)
			->get('/search')
			->assertOk()
			->assertViewIs('pages.search');
	}
}
