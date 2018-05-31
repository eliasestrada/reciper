<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserAccessTest extends DuskTestCase
{
    /** @test */
    public function tryToLoginAsExistingUserAndLogout()
    {
		$this->artisan('migrate:fresh');
		$this->artisan('db:seed');

        $this->browse(function (Browser $browser) {
			$browser
				->visit('/login')
				->type('email', '1990serzhil@gmail.com')
				->type('password', '111111')
				->check('remember')
				->click('#go-to-account')
				->waitForText('Серый')
				->assertSee('Серый')
				->pause(1000)
				->click('#logout-btn')
				->pause(500)
				->assertPathIs('/');
		});
	}
	
	/** @test */
	public function checkIfUserDoesntHaveAccessToProfileAfterRegistration()
	{
		$this->browse(function (Browser $browser) {
			$browser
				->visit('/register')
				->type('name', 'Alex')
				->type('email', 'alex@gmail.com')
				->type('password', '111111')
				->type('password_confirmation', '111111')
				->click('#register-btn')
				->pause(1000)
				->assertPathIs('/recipes')
				->visit('/dashboard')
				->assertPathIs('/recipes');
		});
	}
}
