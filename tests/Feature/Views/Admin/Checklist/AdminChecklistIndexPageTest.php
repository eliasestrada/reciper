<?php

namespace Tests\Feature\Views\Admin\Checklist;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminChecklistIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_admin_checklist_index_has_data(): void
    {
        $admin = create_user('admin');

        $this->actingAs($admin)
            ->get('/admin/checklist')
            ->assertOk()
            ->assertViewIs('admin.checklist.index')
            ->assertViewHas('unapproved',
                Recipe::where([
                    'approved_' . lang() => 0,
                    'ready_' . lang() => 1,
                ])->oldest()->paginate(30)->onEachSide(1));
    }

    /** @test */
    public function user_cant_see_admin_checklist_index_page(): void
    {
        $user = make(User::class);

        $this->actingAs($user)
            ->get('/admin/checklist')
            ->assertRedirect('/');
    }
}
