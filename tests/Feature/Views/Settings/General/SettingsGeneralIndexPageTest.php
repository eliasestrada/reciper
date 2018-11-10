<?php

namespace Tests\Feature\Views\Settings\General;

use App\Models\User;
use App\Notifications\EmailConfirmationNotification;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SettingsGeneralIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @author Cho
     * @test
     */
    public function user_can_see_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get('/settings/general')
            ->assertOk()
            ->assertViewIs('settings.general.index');
    }

    /**
     * @author Cho
     * @test
     */
    public function guest_cant_see_the_page(): void
    {
        $this->get('/settings/general')->assertRedirect();
    }

    /**
     * @author Cho
     * @test
     */
    public function user_can_update_his_name(): void
    {
        $user = create_user();
        $new_name = str_random(7);

        $this->actingAs($user)->put(action('Settings\GeneralController@updateGeneral'), [
            'name' => $new_name,
        ]);
        $this->assertEquals($new_name, $user->name);
    }

    /**
     * @author Cho
     * @test
     */
    public function user_can_change_about_me_information(): void
    {
        $user = create_user();
        $status = str_random(10);

        $this->actingAs($user)->put(action('Settings\GeneralController@updateGeneral'), [
            'name' => $name = str_random(7),
            'status' => $status = str_random(7),
        ]);

        $this->assertEquals($name, $user->name);
        $this->assertEquals($status, $user->status);
    }

    /**
     * @author Cho
     * @test
     */
    public function user_can_change_his_pwd(): void
    {
        $this->actingAs($user = create_user())
            ->put(action('Settings\GeneralController@updatePassword'), [
                'old_password' => '111111',
                'password' => 'new_password',
                'password_confirmation' => 'new_password',
            ]);

        $this->assertTrue(\Hash::check('new_password', $user->password), 'Passwords are not maching');
    }

    /**
     * ['m' => 'd'] doent metter for request
     * @author Cho
     * @test
     * */
    public function user_can_deactivate_account(): void
    {
        $this->actingAs(create_user())
            ->delete(action('UsersController@destroy', ['m' => 'd']), ['password' => '111111'])
            ->assertRedirect('/login');
    }

    /**
     * @author Cho
     * @test
     */
    public function user_cant_deactivate_account_with_wrong_password(): void
    {
        $this->actingAs($user = create_user())->get('/settings/general');

        $this->actingAs($user)
            ->followingRedirects()
            ->delete(action('UsersController@destroy', ['m' => 'd']), ['password' => '22222'])
            ->assertSeeText(trans('settings.pwd_wrong'));
    }

    /**
     * @author Cho
     * @test
     */
    public function sending_notification_after_saving_email_address(): void
    {
        $this->expectsNotification($user = create_user(), EmailConfirmationNotification::class);

        $this->actingAs($user)
            ->put(action('Settings\GeneralController@updateEmail'), [
                'email' => 'testingemail@gmail.com',
            ]);
    }

    /**
     * @author Cho
     * @test
     */
    public function user_cant_change_email_if_he_already_changed_it(): void
    {
        $this->withoutNotifications();
        $user = create_user();

        // First attempt
        $this->actingAs($user)
            ->put(action('Settings\GeneralController@updateEmail'), [
                'email' => 'testingemail@gmail.com',
            ]);

        // Second attempt
        $this->actingAs($user)
            ->followingRedirects()
            ->put(action('Settings\GeneralController@updateEmail'), [
                'email' => 'testingemail@gmail.com',
            ])
            ->assertSeeText(trans('settings.email_change_once_per_week'));
    }
}
