<?php

namespace Tests\Feature\Views\Admin\Feedback;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminFeedbackPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test for feedback page. View: resources/views/admin/feedback/index
     * @return void
     * @test
     */
    public function userCantSeeAdminFeedbackIndexPage(): void
    {
        $this->actingAs(factory(User::class)->make(['admin' => 0]))
            ->get('/admin/feedback')
            ->assertRedirect('/login');
    }
}
