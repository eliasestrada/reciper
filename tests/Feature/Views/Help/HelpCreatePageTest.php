<?php

namespace Tests\Feature\Views\Help;

use App\Models\Help;
use Tests\TestCase;

class HelpCreatePageTest extends TestCase
{
    /**
     * @author Cho
     * @test
     */
    public function page_is_accessible_by_admin(): void
    {
        $this->actingAs(create_user('admin'))
            ->get('/help/create')
            ->assertOk()
            ->assertViewIs('help.create');
    }

    /**
     * @author Cho
     * @test
     */
    public function page_is_not_accessible_by_user(): void
    {
        $this->actingAs(create_user())
            ->get('/help/create')
            ->assertRedirect();
    }

    /**
     * @author Cho
     * @test
     */
    public function page_is_not_accessible_by_guest(): void
    {
        $this->get('/help/create')->assertRedirect();
    }

    /**
     * @author Cho
     * @test
     */
    public function admin_can_add_new_help_answer(): void
    {
        $form_data = [
            'title' => $title = str_random(17),
            'text' => str_random(27),
            'category' => 1,
        ];

        $this->actingAs(create_user('admin'))
            ->post(action('HelpController@store'), $form_data)
            ->assertRedirect('/help');

        $this->assertDatabaseHas('help', [
            'title_' . LANG() => $title,
        ]);
    }
}
