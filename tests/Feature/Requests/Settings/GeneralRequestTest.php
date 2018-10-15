<?php

namespace Tests\Feature\Requests\Settings;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class GeneralRequestTest extends TestCase
{
    use DatabaseTransactions;

    private $name_min;
    private $name_max;
    private $about_me_max;
    private $request;

    public function setUp()
    {
        parent::setUp();
        $this->name_min = config('valid.settings.general.name.min');
        $this->name_max = config('valid.settings.general.name.max');
        $this->about_me_max = config('valid.settings.general.about_me.max');
        $this->request = $this->actingAs(create_user())->followingRedirects();
    }

    /** @test */
    public function name_is_required(): void
    {
        $this->request->put(action('Settings\GeneralController@updateGeneral'), ['name' => ''])
            ->assertSeeText(trans('settings.name_required'));
    }

    /** @test */
    public function name_must_be_not_short(): void
    {
        $this->request->put(action('Settings\GeneralController@updateGeneral'), [
            'name' => str_random($this->name_min - 1),
        ])->assertSeeText(preg_replace('/:min/', $this->name_min, trans('settings.name_min')));
    }

    /** @test */
    public function name_must_be_not_long(): void
    {
        $this->request->put(action('Settings\GeneralController@updateGeneral'), [
            'name' => str_random($this->name_max + 1),
        ])->assertSeeText(preg_replace('/:max/', $this->name_max, trans('settings.name_max')));
    }
}
