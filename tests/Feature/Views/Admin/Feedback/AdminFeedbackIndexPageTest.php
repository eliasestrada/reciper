<?php

namespace Tests\Feature\Views\Admin\Feedback;

use App\Models\Feedback;
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
    public function view_admin_feedback_index_has_data(): void
    {
        $admin = factory(User::class)->make(['admin' => 1]);

        $this->actingAs($admin)
            ->get('/admin/feedback')
            ->assertViewIs('admin.feedback.index')
            ->assertViewHas('feedback', Feedback::paginate(40));
    }

    /**
     * resources/views/admin/feedback/index
     * @test
     * @return void
     */
    public function user_cant_see_admin_feedback_index_page(): void
    {
        $user = factory(User::class)->make();

        $this->actingAs($user)
            ->get('/admin/feedback')
            ->assertRedirect('/');
    }

    /**
     * resources/views/admin/feedback/index
     * @test
     * @return void
     */
    public function admin_can_see_admin_feedback_index_page(): void
    {
        $admin = factory(User::class)->make(['admin' => 1]);

        $this->actingAs($admin)
            ->get('/admin/feedback')
            ->assertOk();
    }
}
