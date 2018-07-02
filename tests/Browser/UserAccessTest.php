<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class UserAccessTest extends DuskTestCase
{
	/** @test */
	public function resisterNewUser()
	{
		$this->browse(function (Browser $browser) {
			$browser
				->visit('/register')
				->type('name', 'Alex')
				->type('email', 'alex@gmail.com')
				->type('password', '111111')
				->type('password_confirmation', '111111')
				->click('#register-btn')
				->assertSee('Alex');
		});
	}

    /** @test */
    public function loginUserAndLogout()
    {
        $this->browse(function (Browser $browser) {
			$browser
				->visit('/login')
				->type('email', 'alex@gmail.com')
				->type('password', '111111')
				->click('#go-to-account')
				->waitForText('Alex')
				->assertSee('Alex')
				->pause(1000)
				->click('#_user-menu')
				->click('#_logout')
				->pause(500)
				->assertPathIs('/');
		});
	}
}
