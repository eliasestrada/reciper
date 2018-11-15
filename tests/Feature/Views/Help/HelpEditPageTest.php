<?php

namespace Tests\Feature\Views\Help;

use App\Models\Help;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class HelpEditPageTest extends TestCase
{
    use DatabaseTransactions;

    private $help;

    /**
     * @author Cho
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->help = create(Help::class);
    }

    /**
     * @author Cho
     * @test
     */
    public function page_is_accessible_by_admin(): void
    {
        $this->actingAs(create_user('admin'))
            ->get("/help/{$this->help->id}/edit")
            ->assertOk()
            ->assertViewIs('help.edit');
    }

    /**
     * @author Cho
     * @test
     */
    public function page_is_not_accessible_by_user(): void
    {
        $this->actingAs(create_user())
            ->get("/help/{$this->help->id}/edit")
            ->assertRedirect();
    }

    /**
     * @author Cho
     * @test
     */
    public function page_is_not_accessible_by_guest(): void
    {
        $this->get("/help/{$this->help->id}/edit")->assertRedirect();
    }

    /**
     * @author Cho
     * @test
     */
    public function admin_can_add_new_help_material(): void
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

    /**
     * @author Cho
     * @test
     */
    public function admin_can_update_help_material(): void
    {
        $help = create(Help::class);
        $form_data = [
            'title' => str_random(17),
            'text' => str_random(27),
            'category' => 1,
        ];

        $this->actingAs(create_user('admin'))
            ->put(action('HelpController@update', ['id' => $help->id]), $form_data)
            ->assertRedirect("/help/{$help->id}/edit");

        $this->assertDatabaseHas('help', [
            'title_' . LANG() => $form_data['title'],
            'text_' . LANG() => $form_data['text'],
        ]);
    }

    /**
     * @author Cho
     * @test
     */
    public function admin_can_delete_help_material(): void
    {
        $help = create(Help::class);

        $this->actingAs(create_user('admin'))
            ->delete(action('HelpController@destroy', ['id' => $help->id]))
            ->assertRedirect("/help");

        $this->assertSoftDeleted('help', [
            'title_' . LANG() => $help->getTitle(),
            'text_' . LANG() => $help->getText(),
        ]);
    }
}
