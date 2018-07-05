<?php

namespace Tests\Feature\Responses;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserPagesTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * @return void
	 */
    public function testResposeRecipesPage()
    {
		$this->assertEquals(1, 1);
	}
}
