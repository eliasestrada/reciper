<?php

namespace Tests\Feature\Views\Admin\Feedback;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminFeedbackPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * @return void
     */
    public function viewAdminFeedbackIndexHasData(): void
    {
        $admin = factory(User::class)->make(['admin' => 1]);

        $this->actingAs($admin)
            ->get('/admin/feedback')
            ->assertViewIs('admin.feedback.index')
            ->assertViewHas('feedback');
    }

    /**
     * Test for feedback page. View: resources/views/admin/feedback/index
     * @return void
     * @test
     */
    public function userCantSeeAdminFeedbackIndexPage(): void
    {
        $user = factory(User::class)->make();

        $this->actingAs($user)
            ->get('/admin/feedback')
            ->assertRedirect('/login');
    }

    /**
     * Test for feedback page. View: resources/views/admin/feedback/index
     * @return void
     * @test
     */
    public function adminCanSeeAdminFeedbackIndexPage(): void
    {
        $admin = factory(User::class)->make(['admin' => 1]);

        $this->actingAs($admin)
            ->get('/admin/feedback')
            ->assertOk();
    }
}
