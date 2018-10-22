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
    public function recipe_is_seen_if_it_is_ready_for_approving(): void
    {
        $recipe = create(Recipe::class, ['approved_' . LANG() => 0, LANG() . '_approver_id' => 0]);

        $this->actingAs(create_user('admin'))
            ->get('/admin/approves/')
            ->assertSeeText(str_limit($recipe->getTitle(), 45));
    }

    /** @test */
    public function admin_redirects_to_recipe_that_he_forgot_to_approve_or_cancel(): void
    {
        $admin = create_user('admin');
        $recipe = create(Recipe::class, ['approved_' . LANG() => 0, LANG() . '_approver_id' => $admin->id]);

        $this->actingAs($admin)
            ->get('/admin/approves')
            ->assertRedirect("/admin/approves/$recipe->id");
    }
}
