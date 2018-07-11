<?php

namespace Tests\Feature\Guest;

use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GuestCanSeePagesTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test for recipes page. View: resources/views/recipes/index
	 * @return void
	 * @test
	 */
    public function guestCanSeeRecipesPage() : void
    {
		$this->get('/recipes')
        	->assertSuccessful()
        	->assertViewIs('recipes.index');
	}

	/**
	 * Test for show recipe page. View: resources/views/recipes/show
	 * @return void
	 * @test
	 */
	public function guestCanSeeShowPage() : void
    {
		$recipe = factory(Recipe::class)->create([
			'ready_ru' => 1,
			'ready_en' => 1,
			'approved_ru' => 1,
			'approved_en' => 1
		]);
		$this->get("/recipes/$recipe->id")
			->assertSuccessful()
			->assertViewIs('recipes.show');
	}

	/**
	 * Test for search page. View: resources/views/pages/search
	 * @return void
	 * @test
	 */
    public function guestCanSeeSearchPage() : void
    {
		$this->get('/search')
			->assertSuccessful()
			->assertViewIs('pages.search');
	}

	/**
	 * Test for home page. View: resources/views/pages/home
	 * @return void
	 * @test
	 */
    public function guestCanSeeHomePage() : void
    {
		$this->get('/')
			->assertSuccessful()
			->assertViewIs('pages.home');
	}

	/**
	 * Test for contact page. View: resources/views/pages/contact
	 * @return void
	 * @test
	 */
	public function guestCanContactPage() : void
    {
		$this->get('/contact')
			->assertSuccessful()
			->assertViewIs('pages.contact');
	}

	/**
	 * Test for login page. View: resources/views/auth/login
	 * @return void
	 * @test
	 */
	public function guestCanSeeLoginPage() : void
	{
		$this->get('/login')
        	->assertSuccessful()
        	->assertViewIs('auth.login');
	}

	/**
	 * Test for register page. View: resources/views/auth/register
	 * @return void
	 * @test
	 */
	public function guestCanSeeRegisterPage() : void
	{
		$this->get('/register')
			->assertSuccessful()
			->assertViewIs('auth.register');
	}

	/**
	 * Test for users page. View: resources/views/users/index
	 * @return void
	 * @test
	 */
	public function guestCanSeeAllRegisteredUsers() : void
	{
		$this->get('/users')
			->assertSuccessful()
			->assertViewIs('users.index');
	}

	/**
	 * Test for user profile page. View: resources/views/users/show
	 * @return void
	 * @test
	 */
	public function guestCanSeeRegisteredUser() : void
	{
		$user = factory(User::class)->create();

		$this->get('/users/' . $user->id)
			->assertSuccessful()
			->assertViewIs('users.show');
	}
}
