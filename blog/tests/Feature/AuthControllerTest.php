<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $userService;

    public function setUp(): void
    {
        parent::setUp();

        // Membuat instance UserService untuk pengujian
        $this->userService = app(UserService::class);
    }

    /** @test */
    public function it_can_register_a_user()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            // 'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/register', $userData);

        $response->assertStatus(201)
            ->assertJson(['message' => 'Berhasil Registerasi!']);
    }

    /** @test */
    public function it_can_login_a_user()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
        ]);

        $loginData = [
            'email' => 'john@example.com',
            'password' => 'password123',
        ];

        $response = $this->postJson('/login', $loginData);

        $response->assertStatus(200)
            ->assertJson(['message' => 'User logged in successfully']);
    }

    /** @test */
    public function it_can_logout_a_user()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
        ]);

        $this->actingAs($user); // Mendaftarkan pengguna untuk pengujian

        $response = $this->postJson('/logout');

        $response->assertStatus(200)
            ->assertJson(['message' => 'User logged out successfully']);
    }
}
