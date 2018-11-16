<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SettingsDuskTest extends DuskTestCase
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
}
