<?php

namespace Feature\Views\Auth\Passwords;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PasswordsEmailTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * @test
	 * @return void
	 */
	public function guestCanSeePasswordEmailPage() : void
	{
		$this->get('/password/reset')
			->assertOk()
			->assertViewIs('auth.passwords.email');
	}

	/**
	 * @test
	 * @return void
	 */
	public function authUserCantSeePasswordEmailPage() : void
	{
		$this->actingAs(User::find(factory(User::class)->create()->id))
			->get('/password/reset')
			->assertRedirect('/dashboard');
	}
}
