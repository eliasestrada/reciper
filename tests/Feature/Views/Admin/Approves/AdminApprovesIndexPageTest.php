<?php

namespace Tests\Feature\Views\Admin\Approves;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminApprovesIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_index_has_data(): void
    {
        $admin = create_user('admin');
        $user = create_user();

        $this->actingAs($admin)
            ->get('/admin/approves')
            ->assertOk()
            ->assertViewIs('admin.approves.index')
            ->assertViewHas([
                'unapproved_waiting' => Recipe::oldest()
                    ->where(lang() . '_approver_id', 0)
                    ->approved(0)
                    ->ready(1)
                    ->paginate(30)
                    ->onEachSide(1),
                'unapproved_checking' => Recipe::oldest()
                    ->where(lang() . '_approver_id', '!=', 0)
                    ->approved(0)
                    ->ready(1)
                    ->paginate(30)
                    ->onEachSide(1),
            ]);
    }

    /** @test */
    public function user_cant_see_index_page(): void
    {
        $user = make(User::class);

        $this->actingAs($user)
            ->get('/admin/approves')
            ->assertRedirect('/');
    }
}
