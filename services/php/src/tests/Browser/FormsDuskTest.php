<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class FormsDuskTest extends DuskTestCase
{
    /**
     * @test
     */
    public function user_can_deactivate_his_account(): void
    {
        $this->browse(function ($first) {
            $first->loginAs(create_user())
                ->visit('/settings')
                ->click('#_modal-trigger')
                ->type('#password', '111111')
                ->click('#_delete-account-button')
                ->assertDialogOpened(trans('settings.are_you_sure_to_deactivate'))
                ->acceptDialog()
                ->assertPathIs('/login')
                ->waitForText(trans('users.account_diactivate'))
                ->assertSee(trans('users.account_diactivate'));
        });
    }

    /**
     * @ Cho
     * @test
     */
    public function password_becomes_visible_after_clicking_eye_icon_on_login_page(): void
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                ->type('#password', 'somepassword')
                ->assertSourceHas('<input type="password"')
                ->click('._visibility-icon')
                ->assertSourceHas('<input type="text"');
        });
    }

    /**
     * @test
     */
    public function password_becomes_visible_after_clicking_eye_icon_on_register_page(): void
    {
        $this->browse(function ($browser) {
            $browser->visit('/register')
                ->type('#password', 'somepassword')
                ->type('#password_confirmation', 'somepassword')
                ->assertSourceHas('<input type="password" id="password"')
                ->assertSourceHas('<input type="password" id="password_confirmation"')
                ->click('._eye-icon-1')
                ->click('._eye-icon-2')
                ->assertSourceHas('<input type="text" id="password"')
                ->assertSourceHas('<input type="text" id="password_confirmation"')
                ->click('._eye-icon-1')
                ->click('._eye-icon-2')
                ->assertSourceHas('<input type="password" id="password"')
                ->assertSourceHas('<input type="password" id="password_confirmation"');
        });
    }

    /**
     * @test
     */
    public function guest_can_read_terms_document_when_registering(): void
    {
        $this->browse(function ($browser) {
            $browser->visit('/register')->click('[href="#show-document-modal"]');
            $this->assertNotNull($browser->element('.modal.open'));
        });
    }
}
