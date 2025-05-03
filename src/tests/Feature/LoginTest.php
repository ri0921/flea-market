<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testEmailIsRequired()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => 'password',
        ]);
        $response->assertRedirect();
        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください']);
    }

    public function testPasswordIsRequired()
    {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => '',
        ]);
        $response->assertRedirect();
        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください']);
    }

    public function testWrongLoginUser()
    {
        $response = $this->post('/login', [
            'email' => 'wrong@example.com',
            'password' => 'wrongpassword',
        ]);
        $response->assertRedirect();
        $response->assertSessionHasErrors([
            'email' => 'ログイン情報が登録されていません']);
    }

    public function testLoginSuccess()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);
        $response->assertRedirect('/?tab=mylist');
        $this->assertAuthenticatedAs($user);
    }

    public function testLogout()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->post('/logout');
        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
