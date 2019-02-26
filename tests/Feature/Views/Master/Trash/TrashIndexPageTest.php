<?php

namespace Tests\Feature\Views\Master\Trash;

use Tests\TestCase;
use App\Models\Help;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TrashIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @author Cho
     * @test
     */
    public function view_is_accessable_by_master(): void
    {
        $this->actingAs(create_user('master'))
            ->get('/master/trash')
            ->assertOk()
            ->assertViewIs('master.trash.index');
    }

    /**
     * @author Cho
     * @test
     */
    public function view_is_not_accessable_by_user(): void
    {
        $this->actingAs(create_user())
            ->get('/master/trash')
            ->assertRedirect();
    }

    /**
     * @author Cho
     * @test
     */
    public function view_is_not_accessable_by_admin(): void
    {
        $this->actingAs(create_user('admin'))
            ->get('/master/trash')
            ->assertRedirect();
    }

    /**
     * @author Cho
     * @test
     */
    public function master_can_see_trashed_materials(): void
    {
        $trash = $this->createTrash();

        $this->actingAs(create_user('master'))
            ->get('/master/trash')
            ->assertSeeText($trash['title']);
    }

    /**
     * @author Cho
     * @test
     */
    public function master_can_delete_trashed_material(): void
    {
        $trash = $this->createTrash();

        $this->actingAs(create_user('master'))
            ->delete(action('Master\TrashController@destroy', [
                'id' => $trash['id'],
            ]), ['table' => 'help'])
            ->assertRedirect('/master/trash');

        $this->assertDatabaseMissing('help', [
            _('title') => $trash['title'],
        ]);
    }

    /**
     * @author Cho
     * @test
     */
    public function master_can_restore_trashed_material(): void
    {
        $trash = $this->createTrash();

        $this->actingAs(create_user('master'))
            ->put(action('Master\TrashController@update', [
                'id' => $trash['id'],
            ]), ['table' => 'help'])
            ->assertRedirect("/help/{$trash['id']}");

        $this->assertDatabaseHas('help', [
            _('title') => $trash['title'],
        ]);
    }

    /**
     * Function helper creates trashed data
     *
     * @return array
     */
    public function createTrash(): array
    {
        $help = create(Help::class);
        $data = [
            'id' => $help->id,
            'title' => $help->getTitle(),
        ];
        $help->delete();
        return $data;
    }
}
