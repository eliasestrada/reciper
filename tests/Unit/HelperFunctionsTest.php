<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HelperFunctionsTest extends TestCase
{
    /**
	 * @test
     * @return void
     */
    public function checkGetDataNotifMarkupHelper() : void
    {
		$this->assertEquals(getDataNotifMarkup(0), '');
		$this->assertEquals(getDataNotifMarkup(-1), '');
		$this->assertEquals(getDataNotifMarkup(1), 'data-notif=1');
	}
	
	/**
	 * @test
	 * @return void
	 */
	public function checkGetOnlineIconHelper() : void
	{
		// Icon should be on ===================
		$expected = '<span class="online-icon-on"></span>';

		$current = getOnlineIcon('30 ' . trans('date.second').' '.trans("date.ago"));
		$this->assertEquals($expected, $current);

		$current = getOnlineIcon('30 ' . trans('date.seconds').' '.trans("date.ago"));
		$this->assertEquals($expected, $current);

		$current = getOnlineIcon('30 ' . trans('date.seconds2').' '.trans("date.ago"));
		$this->assertEquals($expected, $current);

		// Icon should be off ===================
		$expected = '<span class="online-icon-off"></span>';

		$current = getOnlineIcon('30 ' . trans('date.minute').' '.trans("date.ago"));
		$this->assertEquals($expected, $current);

		$current = getOnlineIcon('30 ' . trans('date.minutes').' '.trans("date.ago"));
		$this->assertEquals($expected, $current);

		$current = getOnlineIcon('30 ' . trans('date.minutes2').' '.trans("date.ago"));
		$this->assertEquals($expected, $current);
	}

	/**
	 * @test
	 * @return void
	 */
	public function checkReadableNumberHelper() : void
	{
		$this->assertEquals(readableNumber(999),
			999);
		$this->assertEquals(readableNumber(1000),
			'1<br /><small>' . trans('users.thousand') . '</small>');
		$this->assertEquals(readableNumber(99999),
			'99<br /><small>' . trans('users.thousand') . '</small>');
		$this->assertEquals(readableNumber(1000000),
			'1<br /><small>' . trans('users.million') . '</small>');
	}
}
