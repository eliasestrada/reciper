<?php

namespace Tests\Browser\Views\Auth;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AuthLoginPageTest extends DuskTestCase
{
    /** @test */
    public function logining_in_user_and_logout(): void
    {
        $this->artisan('wipe');

        $this->browse(function (Browser $browser) {
            $user = create(User::class);

            $browser
                ->visit('/login')
                ->type('email', $user->email)
                ->type('password', '111111')
                ->click('.visibility-icon')
                ->click('#go-to-account')
                ->waitForText($user->name)
                ->assertSee($user->name)
                ->click('#_user-menu-trigger')
                ->waitFor('#dropdown2 #_logout_btn')
                ->click('#dropdown2 #_logout_btn')
                ->assertPathIs('/');
        });
    }
}
