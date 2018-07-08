<?php

namespace Tests\Feature\Responses;

use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GuestCanViewPagesTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Test view views/recipes/index
	 * @return void
	 */
    public function testGuestCanSeeRecipesPage() : void
    {
		Artisan::call('migrate:fresh');
		Artisan::call('db:seed');

		$this->get('/recipes')
        	->assertSuccessful()
        	->assertViewIs('recipes.index');
	}

	/**
	 * Test view views/recipes/show
	 * @return void
	 */
	public function testGuestCanSeeShowPage() : void
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
	 * Test view views/pages/search
	 * @return void
	 */
    public function testGuestCanSeeSearchPage() : void
    {
		$this->get('/search')
			->assertSuccessful()
			->assertViewIs('pages.search');
	}

	/**
	 * Test view views/pages/home
	 * @return void
	 */
    public function testGuestCanSeeHomePage() : void
    {
		$this->get('/')
			->assertSuccessful()
			->assertViewIs('pages.home');
	}

	/**
	 * Test view views/pages/contact
	 * @return void
	 */
	public function testGuestCanContactPage() : void
    {
		$this->get('/contact')
			->assertSuccessful()
			->assertViewIs('pages.contact');
	}

	/**
	 * Test view views/auth/login
	 * @return void
	 */
	public function testGuestCanSeeLoginPage() : void
	{
		$this->get('/login')
        	->assertSuccessful()
        	->assertViewIs('auth.login');
	}

	/**
	 * Test view views/auth/register
	 * @return void
	 */
	public function testGuestCanSeeRegisterPage() : void
	{
		$this->get('/register')
			->assertSuccessful()
			->assertViewIs('auth.register');
	}

	/**
	 * Test view views/users/index
	 * @return void
	 */
	public function testGuestCanSeeAllRegisteredUsers() : void
	{
		$this->get('/users')
			->assertSuccessful()
			->assertViewIs('users.index');
	}

	/**
	 * Test view views/users/show
	 * @return void
	 */
	public function testGuestCanSeeRegisteredUser() : void
	{
		$user = factory(User::class)->create();

		$this->get('/users/' . $user->id)
			->assertSuccessful()
			->assertViewIs('users.show');
	}
}
