<?php

namespace Tests\Feature\Views\Help;

use App\Models\Help;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class HelpCreatePageTest extends TestCase
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
            'title' => str_random(17),
            'text' => str_random(27),
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
