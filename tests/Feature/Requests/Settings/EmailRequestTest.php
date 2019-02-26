<?php

namespace Tests\Feature\Requests\Settings;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EmailRequestTest extends TestCase
{
    use DatabaseTransactions;

    private $email_max;

    /**
     * @author Cho
     */
    public function setUp()
    {
        parent::setUp();
        $this->email_max = config('valid.settings.email.max');

        $this->actingAs($user = create_user())->get('/settings/general');
        $this->request = $this->actingAs($user)->followingRedirects();
    }

    /**
     * @author Cho
     * @test
     */
    public function email_must_be_not_long(): void
    {
        $this->request->put(action('Settings\GeneralController@updateEmail'), [
            'email' => str_random($this->email_max + 1),
        ])->assertSeeText(str_replace(':max', $this->email_max, trans('settings.email_max')));
    }

    /**
     * @author cho
     * @test
     */
    public function email_must_proper_email_address(): void
    {
        $this->request->put(action('Settings\GeneralController@updateEmail'), [
            'email' => 'ds123323.com',
        ])->assertseetext(trans('settings.email_email'));
    }

    /**
     * @author cho
     * @test
     */
    public function email_must_be_unique(): void
    {
        create_user('', ['email' => 'test@email.com']);
        $this->request->put(action('Settings\GeneralController@updateEmail'), [
            'email' => 'test@email.com',
        ])->assertseetext(trans('settings.email_unique'));
    }

    /**
     * @author cho
     * @test
     */
    public function correct_email_request(): void
    {
        $this->withoutNotifications();
        $this->request->put(action('Settings\GeneralController@updateEmail'), [
            'email' => 'someemail@mail.com',
        ])->assertseetext(trans('settings.saved_now_verify_email'));
    }
}
