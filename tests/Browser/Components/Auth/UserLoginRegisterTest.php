<?php

namespace Tests\Browser\Components\Auth;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserLoginRegisterTest extends DuskTestCase
{
    /**
     * @test
     * @return void
     * */
    public function registering_a_new_user_and_logout(): void
    {
        $this->artisan('wipe');

        $this->browse(function (Browser $browser) {
            $browser->maximize()
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

    /**
     * @test
     * @return void
     * */
    public function loging_in_user_and_logout(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->maximize()
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
