<?php

namespace Tests\Feature\Views\Settings\Photo;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class SettingsPhotoIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_has_a_correct_path(): void
    {
        $this->actingAs(make(User::class))
            ->get('/settings/photo')
            ->assertOk()
            ->assertViewIs('settings.photo.index');
    }

    /** @test */
    public function guest_cant_see_the_page(): void
    {
        $this->get('/settings/photo')->assertRedirect('/login');
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
    public function user_can_delete_his_photo(): void
    {
        $user = create_user('', ['image' => 'some/image.jpg']);

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
