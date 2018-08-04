<?php

namespace Tests\Feature\Views\Admin\Feedback;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminFeedbackPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * resources/views/admin/feedback/index
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
     * resources/views/admin/feedback/index
     * @test
     * @return void
     */
    public function userCantSeeAdminFeedbackIndexPage(): void
    {
        $user = factory(User::class)->make();

        $this->actingAs($user)
            ->get('/admin/feedback')
            ->assertRedirect('/login');
    }

    /**
     * resources/views/admin/feedback/index
     * @test
     * @return void
     */
    public function adminCanSeeAdminFeedbackIndexPage(): void
    {
        $admin = factory(User::class)->make(['admin' => 1]);

        $this->actingAs($admin)
            ->get('/admin/feedback')
            ->assertOk();
    }
}
