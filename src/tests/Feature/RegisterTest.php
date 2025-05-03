<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testNameIsRequired()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertRedirect();
        $response->assertSessionHasErrors(['name' => 'お名前を入力してください']);
    }

    public function testEmailIsRequired()
    {
        $response = $this->post('/register', [
            'name' => 'ユーザー',
            'email' => '',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertRedirect();
        $response->assertSessionHasErrors(['email' => 'メールアドレスを入力してください']);
    }

    public function testPasswordIsRequired()
    {
        $response = $this->post('/register', [
            'name' => 'ユーザー',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => '',
        ]);
        $response->assertRedirect();
        $response->assertSessionHasErrors(['password' => 'パスワードを入力してください']);
    }

    public function testPasswordMin()
    {
        $response = $this->post('/register', [
            'name' => 'ユーザー',
            'email' => 'test@example.com',
            'password' => 'passwor',
            'password_confirmation' => 'passwor',
        ]);
        $response->assertRedirect();
        $response->assertSessionHasErrors(['password' => 'パスワードは8文字以上で入力してください']);
    }

    public function testPasswordConfirmationDoesNotMatch()
    {
        $response = $this->post('/register', [
            'name' => 'ユーザー',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'different',
        ]);
        $response->assertRedirect();
        $response->assertSessionHasErrors(['password_confirmation' => 'パスワードと一致しません']);
    }

    public function testRegisterSuccess()
    {
        $response = $this->post('/register', [
            'name' => 'ユーザー',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertRedirect('/mypage/profile');
        $this->assertDatabaseHas('users', [
            'name' => 'ユーザー',
            'email' => 'test@example.com',
        ]);
    }
}
