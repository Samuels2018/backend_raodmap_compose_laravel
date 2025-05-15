<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase {
  use RefreshDatabase;

  public function test_user_registration() {
    $response = $this->postJson('/api/auth/register', [
      'name' => 'Test User',
      'email' => 'test@example.com',
      'password' => 'password',
      'password_confirmation' => 'password',
    ]);

    $response->assertStatus(201)
      ->assertJsonStructure([
        'message',
        'user' => ['id', 'name', 'email']
      ]);
  }

  public function test_user_login() {
    $user = User::factory()->create([
      'email' => 'test@example.com',
      'password' => bcrypt('password'),
    ]);

    $response = $this->postJson('/api/auth/login', [
      'email' => 'test@example.com',
      'password' => 'password',
    ]);

    $response->assertStatus(200)
      ->assertJsonStructure([
        'access_token',
        'token_type',
        'expires_in',
        'user'
      ]);
  }
}
