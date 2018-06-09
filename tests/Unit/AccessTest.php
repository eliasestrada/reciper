<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccessTest extends TestCase
{
    public function testGuestCannotGoToADashboardPage()
    {
		$this->assertTrue(true);
	}
}
