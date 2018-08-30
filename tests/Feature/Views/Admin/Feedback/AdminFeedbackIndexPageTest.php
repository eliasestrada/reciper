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
     * @test
     * @return void
     */
    public function view_admin_feedback_index_has_data(): void
    {
        $admin = make(User::class, ['admin' => 1]);

        $this->actingAs($admin)
            ->get('/admin/feedback')
            ->assertViewIs('admin.feedback.index')
            ->assertViewHas('feedback', Feedback::paginate(40));
    }

    /**
     * @test
     * @return void
     */
    public function user_cant_see_admin_feedback_index_page(): void
    {
        $user = make(User::class);

        $this->actingAs($user)
            ->get('/admin/feedback')
            ->assertRedirect('/');
    }

    /**
     * @test
     * @return void
     */
    public function admin_can_see_admin_feedback_index_page(): void
    {
        $admin = make(User::class, ['admin' => 1]);

        $this->actingAs($admin)
            ->get('/admin/feedback')
            ->assertOk();
    }
}
