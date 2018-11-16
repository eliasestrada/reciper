<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class FormsDuskTest extends DuskTestCase
{
    /**
     * @author Cho
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
     * @author Cho
     * @test
     */
    public function password_becomes_visible_after_clicking_eye_icon(): void
    {
        $this->browse(function ($browse) {
            $browse->visit('/login')
                ->type('#password', 'somepassword')
                ->assertSourceHas('<input type="password"')
                ->click('._visibility-icon')
                ->assertSourceHas('<input type="text"');
        });
    }
}
