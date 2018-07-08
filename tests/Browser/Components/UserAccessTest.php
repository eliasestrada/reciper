<?php

namespace Tests\Browser\Components;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class UserAccessTest extends DuskTestCase
{
	/** @test */
	public function resisterNewUserAndLogout()
	{
		$this->browse(function (Browser $browser) {
			$browser
				->visit('/register')
				->type('name', 'Alex')
				->type('email', 'alex@gmail.com')
				->type('password', '111111')
				->type('password_confirmation', '111111')
				->click('#register-btn')
				->assertSee('Alex')
				->click('#_user-menu-trigger')
				->waitFor('#dropdown2 #_logout_btn')
				->click('#dropdown2 #_logout_btn')
				->assertPathIs('/');
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
				->click('#_user-menu-trigger')
				->waitFor('#dropdown2 #_logout_btn')
				->click('#dropdown2 #_logout_btn')
				->assertPathIs('/');
		});
	}
}
