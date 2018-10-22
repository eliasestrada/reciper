<?php

namespace Tests\Feature\Views\Admin\Feedback;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminFeedbackIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_has_data(): void
    {
        $this->actingAs(create_user('admin'))
            ->get('/admin/feedback')
            ->assertOk()
            ->assertViewIs('admin.feedback.index')
            ->assertViewHasAll(['feedback_ru', 'feedback_en']);
    }

    /** @test */
    public function user_cant_see_the_page(): void
    {
        $this->actingAs(make(User::class))->get('/admin/feedback')->assertRedirect('/');
    }

    /** @test */
    public function admin_sees_the_message_if_it_exist(): void
    {
        $feed = Feedback::create([
            'visitor_id' => 1,
            'lang' => LANG(),
            'email' => 'denis@gmail.com',
            'message' => $msg = str_random(20),
        ]);

        // Go to admin's feedback page
        $this->actingAs(create_user('admin'))
            ->get('/admin/feedback')
            ->assertSeeText($msg);
    }

    /** @test */
    public function feedback_message_can_be_deleted_by_admin(): void
    {
        $feed = Feedback::create([
            'visitor_id' => 1,
            'lang' => LANG(),
            'email' => 'johndoe@gmail.com',
            'message' => str_random(20),
        ]);

        // Delete the feed message
        $this->actingAs(create_user('admin'))
            ->delete(action('Admin\FeedbackController@destroy', ['id' => $feed->id]));

        $this->assertDatabaseMissing('feedback', $feed->toArray());
    }
}
