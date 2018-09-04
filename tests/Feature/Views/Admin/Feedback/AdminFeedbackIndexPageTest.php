<?php

namespace Tests\Feature\Views\Admin\Feedback;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminFeedbackPageTest extends TestCase
{
    use DatabaseTransactions;

    private $admin;

    public function setUp(): void
    {
        parent::setUp();

        $this->admin = make(User::class, ['admin' => 1]);
    }

    /** @test */
    public function view_admin_feedback_index_has_data(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/feedback')
            ->assertViewIs('admin.feedback.index')
            ->assertViewHas('feedback', Feedback::paginate(40));
    }

    /** @test */
    public function user_cant_see_admin_feedback_index_page(): void
    {
        $user = make(User::class);

        $this->actingAs($user)
            ->get('/admin/feedback')
            ->assertRedirect('/');
    }

    /** @test */
    public function admin_can_see_admin_feedback_index_page(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/feedback')
            ->assertOk();
    }

    /** @test */
    public function feedback_message_can_be_deleted_by_admin(): void
    {
        $message = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae facere ex animi quis!';

        $feed = Feedback::create([
            'email' => 'johndoe@gmail.com',
            'message' => $message,
        ]);

        // Go to admin's feedback page
        $this->actingAs($this->admin)
            ->get('/admin/feedback')
            ->assertSeeText($message);

        // Delete the feed message
        $this->actingAs($this->admin)
            ->followingRedirects()
            ->delete(action('Admin\FeedbackController@destroy', [
                'id' => $feed->id,
            ]))
            ->assertSeeText(trans('admin.feedback_has_been_deleted'));

        $this->assertDatabaseMissing('feedback', $feed->toArray());
    }
}
