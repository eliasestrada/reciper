<?php

namespace Tests\Feature\Views\Master\Help;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MasterHelpCreatePageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @author Cho
     * @test
     */
    public function page_is_accessible_by_admin(): void
    {
        $this->actingAs(create_user('admin'))
            ->get('/master/help/create')
            ->assertOk()
            ->assertViewIs('master.help.create');
    }

    /**
     * @author Cho
     * @test
     */
    public function page_is_not_accessible_by_user(): void
    {
        $this->actingAs(create_user())
            ->get('/master/help/create')
            ->assertRedirect();
    }

    /**
     * @author Cho
     * @test
     */
    public function page_is_not_accessible_by_guest(): void
    {
        $this->get('/master/help/create')->assertRedirect();
    }

    /**
     * @author Cho
     * @test
     */
    public function admin_can_add_new_help_answer(): void
    {
        $form_data = [
            'title' => string_random(17),
            'text' => string_random(27),
            'category' => 1,
        ];

        $this->actingAs(create_user('admin'))
            ->post(action('Master\HelpController@store'), $form_data)
            ->assertRedirect('/help');

        $this->assertDatabaseHas('help', [
            _('title') => $form_data['title'],
            _('text') => $form_data['text'],
        ]);
    }
}
