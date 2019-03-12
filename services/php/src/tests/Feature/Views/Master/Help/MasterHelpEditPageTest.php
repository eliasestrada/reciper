<?php

namespace Tests\Feature\Views\Master\Help;

use Tests\TestCase;
use App\Models\Help;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MasterHelpEditPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var \App\Models\Help
     */
    private $help;

    /**
     * @var string
     */
    private $url;

    /**
     * Setup the test environment
     * 
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->help = create(Help::class);
        $this->url = "/master/help/{$this->help->id}/edit";
    }

    /**
     * @test
     */
    public function page_is_accessible_by_admin(): void
    {
        $this->actingAs(create_user('admin'))
            ->get($this->url)
            ->assertOk()
            ->assertViewIs('master.help.edit');
    }

    /**
     * @test
     */
    public function page_is_not_accessible_by_user(): void
    {
        $this->actingAs(create_user())
            ->get($this->url)
            ->assertRedirect();
    }

    /**
     * @test
     */
    public function page_is_not_accessible_by_guest(): void
    {
        $this->get($this->url)->assertRedirect();
    }

    /**
     * @test
     */
    public function admin_can_add_new_help_material(): void
    {
        $form_data = [
            'title' => $title = string_random(17),
            'text' => string_random(27),
            'category' => 1,
        ];

        $this->actingAs(create_user('admin'))
            ->post(action('Master\HelpController@store'), $form_data)
            ->assertRedirect('/help');

        $this->assertDatabaseHas('help', [
            _('title') => $title,
        ]);
    }

    /**
     * @test
     */
    public function admin_can_update_help_material(): void
    {
        $help = create(Help::class);
        $form_data = [
            'title' => string_random(17),
            'text' => string_random(27),
            'category' => 1,
        ];

        $this->actingAs(create_user('admin'))
            ->put(action('Master\HelpController@update', [
                'id' => $help->id,
            ]), $form_data)
            ->assertRedirect("/master/help/{$help->id}/edit");

        $this->assertDatabaseHas('help', [
            _('title') => $form_data['title'],
            _('text') => $form_data['text'],
        ]);
    }

    /**
     * @test
     */
    public function admin_can_delete_help_material(): void
    {
        $help = create(Help::class);

        $this->actingAs(create_user('admin'))
            ->delete(action('Master\HelpController@destroy', ['id' => $help->id]))
            ->assertRedirect("/help");

        $this->assertSoftDeleted('help', [
            _('title') => $help->getTitle(),
            _('text') => $help->getText(),
        ]);
    }
}
