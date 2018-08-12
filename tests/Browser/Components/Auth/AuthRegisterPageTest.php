<?php

namespace Tests\Browser\Components\Auth;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AuthRegisterPageTest extends DuskTestCase
{
    /**
     * @test
     * @return void
     * */
    public function registering_a_new_user_and_logout(): void
    {
        $this->artisan('wipe');

        $this->browse(function (Browser $browser) {
            $user = factory(User::class)->make();

            $browser
                ->visit('/register')
                ->type('name', $user->name)
                ->type('email', $user->email)
                ->type('password', '111111')
                ->type('password_confirmation', '111111')
                ->click('#register-btn')
                ->assertSee($user->name)
                ->click('#_user-menu-trigger')
                ->waitFor('#dropdown2 #_logout_btn')
                ->click('#dropdown2 #_logout_btn')
                ->assertPathIs('/');
        });
    }
}
