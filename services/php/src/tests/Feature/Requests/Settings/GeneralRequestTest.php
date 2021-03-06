<?php

namespace Tests\Feature\Requests\Settings;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GeneralRequestTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var int
     */
    private $name_min;

    /**
     * @var int
     */
    private $name_max;

    /**
     * @var int
     */
    private $about_me_max;

    /**
     * @var \Illuminate\Foundation\Testing\TestResponse
     */
    private $request;

    /**
     * Setup the test environment
     * 
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->name_min = config('valid.settings.general.name.min');
        $this->name_max = config('valid.settings.general.name.max');
        $this->about_me_max = config('valid.settings.general.status.max');

        $this->actingAs($user = create_user())->get('/settings/general');
        $this->request = $this->actingAs($user)->followingRedirects();
    }

    /**
     * @test
     */
    public function name_must_be_not_short(): void
    {
        $this->request->put(action('Settings\GeneralController@updateGeneral'), [
            'name' => string_random($this->name_min - 1),
        ])->assertSeeText(preg_replace('/:min/', $this->name_min, trans('settings.name_min')));
    }

    /**
     * @test
     */
    public function name_must_be_not_long(): void
    {
        $this->request->put(action('Settings\GeneralController@updateGeneral'), [
            'name' => string_random($this->name_max + 1),
        ])->assertSeeText(preg_replace('/:max/', $this->name_max, trans('settings.name_max')));
    }
}
