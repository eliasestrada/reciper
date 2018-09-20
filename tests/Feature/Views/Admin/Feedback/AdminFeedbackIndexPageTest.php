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
            ->assertViewHasAll([
                'feedback_ru' => Feedback::with('recipe')->whereLang('ru')->latest()->paginate(20)->onEachSide(1),
                'feedback_en' => Feedback::with('recipe')->whereLang('en')->latest()->paginate(20)->onEachSide(1),
            ]);
    }

    /** @test */
    public function user_cant_see_the_page(): void
    {
        $user = make(User::class);

        $this->actingAs($user)
            ->get('/admin/feedback')
            ->assertRedirect('/');
    }

    /** @test */
    public function feedback_message_can_be_deleted_by_admin(): void
    {
        $message = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae facere ex animi quis!';

        $feed = Feedback::create([
            'visitor_id' => create(Visitor::class)->id,
            'lang' => lang(),
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
