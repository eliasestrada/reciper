<?php

namespace Tests\Feature\Views\Settings\Photo;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
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
    public function user_can_delete_his_photo(): void
    {
        $user = create_user('', ['image' => 'some/image.jpg']);

        $this->actingAs($user)->delete(action('Settings\PhotoController@destroy'));
        $this->assertEquals('default.jpg', $user->image);
    }
}
