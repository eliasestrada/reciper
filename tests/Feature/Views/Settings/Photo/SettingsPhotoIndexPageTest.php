<?php

namespace Tests\Feature\Views\Settings\Photo;

use App\Jobs\DeleteImageJob;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class SettingsPhotoIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function user_can_see_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get('/settings/photo')
            ->assertOk()
            ->assertViewIs('settings.photo.index');
    }

    /** @test */
    public function guest_cant_see_the_page(): void
    {
        $this->get('/settings/photo')->assertRedirect();
    }

    /** @test */
    public function user_can_upload_new_profile_photo(): void
    {
        $user = create_user();

        $this->actingAs($user)->put(action('Settings\PhotoController@update'), [
            'image' => UploadedFile::fake()->image('image.jpg'),
        ]);
        $this->assertNotEquals('default.jpg', $user->image);
        $this->assertFileExists(storage_path("app/public/users/$user->image"));
        $this->assertFileExists(storage_path("app/public/small/users/$user->image"));
        $this->cleanAfterYourself($user->image);
    }

    /** @test */
    public function delete_photo_request_dispaches_job_DeleteImageJob(): void
    {
        Queue::fake();

        $user = create_user('', ['image' => 'some/image.jpg']);
        $this->actingAs($user)->delete(action('Settings\PhotoController@destroy'));

        Queue::assertPushed(DeleteImageJob::class, function ($job) {
            return $job->image_name == 'some/image.jpg';
        });
    }

    /** @test */
    public function if_profile_image_is_default_DeleteImageJob_is_not_queued(): void
    {
        Queue::fake();

        $this->actingAs(create_user())
            ->delete(action('Settings\PhotoController@destroy'));

        Queue::assertNotPushed(DeleteImageJob::class);
    }

    /** @test */
    public function after_delete_photo_request_image_column_is_set_to_default_jpg(): void
    {
        $user = create_user('', ['image' => 'another/image.jpg']);

        $this->withoutJobs();
        $this->actingAs($user)->delete(action('Settings\PhotoController@destroy'));
        $this->assertEquals('default.jpg', $user->image);
    }

    /**
     * Helper function
     * @param string $image_path
     * @return void
     */
    private function cleanAfterYourself(string $image_path): void
    {
        \Storage::delete([
            "public/users/$image_path",
            "public/small/users/$image_path",
        ]);
    }
}
