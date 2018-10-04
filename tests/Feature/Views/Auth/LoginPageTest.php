<?php

namespace Tests\Feature\Views\Auth;

use App\Models\User;
use Auth;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LoginPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function user_can_login_with_correct_credentials(): void
    {
        $user = create(User::class, ['password' => bcrypt('test')]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'test',
        ]);
        $response->assertRedirect('/dashboard');
    }

    /** @test */
    public function user_cannot_login_with_incorrect_password(): void
    {
        $user = create(User::class, ['password' => bcrypt('test')]);

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'invalid-password',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');

        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    /**
     * We will login user and create cookie to check them
     * @test
     * @return void
     */
    public function remember_me_functionality(): void
    {
        $user = create(User::class, [
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

    /** @test */
    public function user_cant_see_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get('/login')
            ->assertRedirect('/dashboard')
            ->assertRedirect(action('DashboardController@index'));
    }

    /** @test */
    public function guest_can_see_the_page(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertViewIs('auth.enter');
    }
}
