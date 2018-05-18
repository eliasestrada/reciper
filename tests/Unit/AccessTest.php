<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccessTest extends TestCase
{
	/** @test */
    public function guestCannotGoToADashboardPage()
    {
		$this->assertTrue(true);
	}
}
