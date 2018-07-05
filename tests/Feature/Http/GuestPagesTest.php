<?php

namespace Tests\Feature\Responses;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GuestPagesTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test view views/recipes/index
	 * @return void
	 */
    public function testResposeRecipesPage() : void
    {
		$this->get('/recipes')
        	->assertSuccessful()
        	->assertViewIs('recipes.index');
	}

	/**
	 * Test view views/recipes/show
	 * @return void
	 */
	public function testResposeShowPage() : void
    {
		$recipe = factory(\App\Models\Recipe::class)->create();
		$this->get("/recipes/$recipe->id")
			->assertSuccessful()
			->assertViewIs('recipes.show');
	}

	/**
	 * Test view views/pages/search
	 * @return void
	 */
    public function testResposeSearchPage() : void
    {
		$this->get('/search')
			->assertSuccessful()
			->assertViewIs('pages.search');
	}

	/**
	 * Test view views/pages/home
	 * @return void
	 */
    public function testResposeHomePage() : void
    {
		$this->get('/')
			->assertSuccessful()
			->assertViewIs('pages.home');
	}

	/**
	 * Test view views/pages/contact
	 * @return void
	 */
	public function testResposeContactPage() : void
    {
		$this->get('/contact')
			->assertSuccessful()
			->assertViewIs('pages.contact');
	}
}
