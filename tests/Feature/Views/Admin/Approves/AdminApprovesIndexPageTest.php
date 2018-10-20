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
    public function view_has_data(): void
    {
        $this->actingAs(create_user('admin'))
            ->get('/admin/approves')
            ->assertOk()
            ->assertViewIs('admin.approves.index')
            ->assertViewHas([
                'unapproved_waiting',
                'unapproved_checking',
                'my_approves',
            ]);
    }

    /** @test */
    public function user_cant_see_the_page(): void
    {
        $this->actingAs(make(User::class))->get('/admin/approves')->assertRedirect('/');
    }

    /** @test */
    public function recipes_are_seen_if_they_are_ready_for_approving(): void
    {
        $recipe1 = create(Recipe::class, ['approved_' . LANG => 0, LANG . '_approver_id' => 0]);
        $recipe2 = create(Recipe::class, ['approved_' . LANG => 0, LANG . '_approver_id' => 0]);

        $this->actingAs(create_user('admin'))
            ->get('/admin/approves/')
            ->assertSeeText(str_limit($recipe1->getTitle(), 45))
            ->assertSeeText(str_limit($recipe2->getTitle(), 45));
    }
}
