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
            ->assertViewIs('auth.login');
    }

    /** @test */
    public function user_can_login(): void
    {
        $form_data = ['username' => create(User::class)->username, 'password' => '111111'];
        $this->post('/login', $form_data)->assertRedirect('/dashboard');
    }

    /**
     * We will login user and create cookie to check them
     * @test
     * @return void
     */
    public function remember_me_functionality_works(): void
    {
        $user = create(User::class);
        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => '111111',
            'remember' => 'on',
        ]);

        // Creating cookie
        $cookie = vsprintf('%s|%s|%s', [
            $user->id,
            $user->getRememberToken(),
            $user->password,
        ]);

        $response->assertCookie(Auth::guard()->getRecallerName(), $cookie);
    }
}
