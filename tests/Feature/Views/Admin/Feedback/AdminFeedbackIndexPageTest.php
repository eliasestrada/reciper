<?php

namespace Tests\Feature\Views\Admin\Feedback;

use Tests\TestCase;
use App\Models\User;
use App\Models\Feedback;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminFeedbackIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @author Cho
     * @test
     */
    public function admin_can_see_the_page(): void
    {
        $this->actingAs(create_user('admin'))
            ->get('/admin/feedback')
            ->assertOk()
            ->assertViewIs('admin.feedback.index');
    }

    /**
     * @author Cho
     * @test
     */
    public function user_cant_see_the_page(): void
    {
        $this->actingAs(make(User::class))->get('/admin/feedback')->assertRedirect('/');
    }

    /**
     * @author Cho
     * @test
     */
    public function admin_sees_the_message_if_it_exist(): void
    {
        $feed = Feedback::create([
            'visitor_id' => 1,
            'lang' => _(),
            'email' => 'denis@gmail.com',
            'message' => $msg = string_random(20),
        ]);

        // Go to admin's feedback page
        $this->actingAs(create_user('admin'))
            ->get('/admin/feedback')
            ->assertSeeText($msg);
    }

    /**
     * @author Cho
     * @test
     */
    public function feedback_message_can_be_deleted_by_admin(): void
    {
        $feed = Feedback::create([
            'visitor_id' => 1,
            'lang' => _(),
            'email' => 'johndoe@gmail.com',
            'message' => string_random(20),
        ]);

        // Delete the feed message
        $this->actingAs(create_user('admin'))
            ->delete(action('Admin\FeedbackController@destroy', ['id' => $feed->id]));

        $this->assertDatabaseMissing('feedback', $feed->toArray());
    }
}
