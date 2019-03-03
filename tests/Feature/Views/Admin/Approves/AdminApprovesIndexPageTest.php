<?php

namespace Tests\Feature\Views\Admin\Approves;

use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminApprovesIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @author Cho
     * @test
     */
    public function admin_can_see_the_page(): void
    {
        $this->actingAs(create_user('admin'))
            ->get('/admin/approves')
            ->assertOk()
            ->assertViewIs('admin.approves.index');
    }

    /**
     * @author Cho
     * @test
     */
    public function user_cant_see_the_page(): void
    {
        $this->actingAs(make(User::class))->get('/admin/approves')->assertRedirect('/');
    }

    /**
     * @author Cho
     * @test
     */
    public function recipe_is_seen_if_it_is_ready_for_approving(): void
    {
        $recipe = create(Recipe::class, [_('approved') => 0, _('approver_id', true) => 0]);

        $this->actingAs(create_user('admin'))
            ->get('/admin/approves')
            ->assertSeeText(string_limit($recipe->getTitle(), 45));
    }

    /**
     * @author Cho
     * @test
     */
    public function admin_redirects_to_recipe_that_he_forgot_to_approve_or_cancel(): void
    {
        $admin = create_user('admin');
        $recipe = create(Recipe::class, [_('approved') => 0, _('approver_id', true) => $admin->id]);

        $this->actingAs($admin)
            ->get('/admin/approves')
            ->assertRedirect("/admin/approves/{$recipe->slug}");
    }
}
