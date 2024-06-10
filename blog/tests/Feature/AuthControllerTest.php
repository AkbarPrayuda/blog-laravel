<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'akbar',
            'email' => 'akbar@gmail.com',
            'password' => 'password',
        ]);

        $response->assertStatus(201);
    }

    public function test_registration_requires_name_email_and_password()
    {
        $response = $this->postJson('/api/register', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    public function test_user_can_login()
    {
        $user = $this->postJson('/api/register', [
            'name' => 'akbar',
            'email' => 'akbar@gmail.com',
            'password' => 'password',
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'akbar@gmail.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    public function test_user_can_logout()
    {
        $user = User::create([
            'name' => 'akbar',
            'password' => Hash::make('password'),
            'email' => 'akbar@gmail.com'
        ]);
        $token = $user->createToken('API Token')->plainTextToken;

        $response = $this->actingAs($user)->postJson('/api/logout');

        $response->assertStatus(200)
            ->assertExactJson(['message' => 'Successfully logged out']);
    }
}
