<?php

namespace Tests\Feature\Views\Auth;

use Auth;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function user_cant_see_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get('/login')
            ->assertRedirect();
    }

    /**
     * @test
     */
    public function guest_can_see_the_page(): void
    {
        $this->get('/login')->assertOk()->assertViewIs('auth.login');
    }

    /**
     * @test
     */
    public function user_can_login(): void
    {
        $form_data = [
            'username' => create_user()->username,
            'password' => '11111111'
        ];
        $this->post('/login', $form_data)->assertRedirect('/dashboard');
    }

    /**
     * We will login user and create cookie to check them
     * 
     * @test
     */
    public function remember_me_functionality_works(): void
    {
        $user = create_user();

        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => '11111111',
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
