<?php

namespace Tests\Feature\Views\Admin\Feedback;

use App\Models\Feedback;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminFeedbackIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    private $admin;

    public function setUp(): void
    {
        parent::setUp();
        $this->admin = create_user('admin');
    }

    /** @test */
    public function view_has_data(): void
    {
        $this->actingAs($this->admin)
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
    public function feedback_message_can_be_deleted_by_admin(): void
    {
        $msg = str_random(40);

        $feed = Feedback::create([
            'visitor_id' => create(Visitor::class)->id,
            'lang' => LANG(),
            'email' => 'johndoe@gmail.com',
            'message' => $msg,
        ]);

        // Go to admin's feedback page
        $this->actingAs($this->admin)
            ->get('/admin/feedback')
            ->assertSeeText($msg);

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
