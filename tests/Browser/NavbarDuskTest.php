<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class NavbarDuskTest extends DuskTestCase
{
    /**
     * @author Cho
     * @test
     */
    public function theme_changes_to_dark_after_swithing_it_on(): void
    {
        $this->browse(function ($browse) {
            $browse->visit('/recipes')
                ->click('#_hamb-menu')
                ->assertSourceHas('<body class="">')
                ->waitFor('.lever')
                ->click('.lever')
                ->assertSourceHas('<body class="dark-theme">')
                ->click('.lever')
                ->assertSourceHas('<body class="">');
        });
    }

    /**
     * @author Cho
     * @test
     */
    public function dark_theme_remains_after_turning_it_on_and_going_to_another_page(): void
    {
        $this->browse(function ($browse) {
            $browse->visit('/recipes')
                ->click('#_hamb-menu')
                ->waitFor('.lever')
                ->click('.lever')
                ->visit('/search')
                ->assertSourceHas('<body class="dark-theme">');
        });
    }

    /**
     * @author Cho
     * @test
     */
    public function user_can_use_navbar_search_to_find_recipe(): void
    {
        $this->browse(function ($browse) {
            $browse->visit('/')
                ->click('#nav-btn-for-search')
                ->type('#search-input', 'морковь')
                ->keys('#search-input', '{enter}')
                ->assertPathIs('/search');
        });
    }

    /**
     * @author Cho
     * @test
     */
    public function categories_dropdown_appears_after_clicking_the_button(): void
    {
        $this->browse(function ($browse) {
            $browse->visit('/')
                ->click('[data-target="categories-dropdown"]')
                ->click('#categories-dropdown li:first-child')
                ->assertPathIs('/recipes');
        });
    }

    /**
     * @author Cho
     * @test
     */
    public function sidenav_appears_after_clicking_trigger_hamburger_menu(): void
    {
        $this->browse(function ($browser) {
            $browser->resize(500, 800)
                ->visit('/')
                ->click('.sidenav-trigger');

            $this->assertNotNull($browser->element('#mobile-sidenav'));
        });
    }

    /**
     * @author Cho
     * @test
     */
    public function admin_menu_appears_after_clicking_admin_button(): void
    {
        $this->browse(function ($user) {
            $user->loginAs(create_user('admin'))
                ->visit('/')
                ->click('a[data-target=user-menu-dropdown]')
                ->waitFor('#adminka-collapsible')
                ->click('#adminka-collapsible > li')
                ->assertSee(trans('approves.checklist'))
                ->assertSee(trans('feedback.contact_us'));
        });
    }

    /**
     * @author Cho
     * @test
     */
    public function admin_menu_is_invisible_for_simple_users(): void
    {
        $this->browse(function ($user) {
            $user->loginAs(create_user())
                ->visit('/')
                ->click('a[data-target=user-menu-dropdown]')
                ->assertDontSee(trans('messages.adminka'));
        });
    }
}
