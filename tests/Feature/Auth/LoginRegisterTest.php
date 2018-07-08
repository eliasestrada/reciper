<?php

namespace Tests\Feature\Auth;

use Auth;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginRegisterTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * @return void
	 * @test
	 */
	public function userCanLoginWithCorrectCredentials() : void
    {
		$user = factory(User::class)->create(['password' => bcrypt('test')]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'test'
		]);
		$response->assertRedirect('/dashboard');
	}

	/**
	 * @return void
	 * @test
	 */
	public function userCannotLoginWithIncorrectPassword() : void
    {
        $user = factory(User::class)->create(['password' => bcrypt('test')]);

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'invalid-password'
        ]);

        $response->assertRedirect('/login');
		$response->assertSessionHasErrors('email');

        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
	}

	/**
	 * We will login user and create cookie to check them
	 * @return void
	 * @test
	 */
	public function rememberMeFunctionality() : void
    {
        $user = factory(User::class)->create([
            'id' => random_int(10, 100),
            'password' => bcrypt('test'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'test',
            'remember' => 'on',
        ]);

		$response->assertRedirect('/dashboard');

		// Creating cookie
        $cookie = vsprintf('%s|%s|%s', [
			$user->id,
			$user->getRememberToken(),
			$user->password,
		]);

		$response->assertCookie(Auth::guard()->getRecallerName(), $cookie);
    }
}
