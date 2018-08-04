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
    public function resisterNewUserAndLogout(): void
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

    /**
     * @test
     * @return void
     * */
    public function loginUserAndLogout(): void
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

        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }
}
