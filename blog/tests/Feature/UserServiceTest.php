<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $userService;

    public function setUp(): void
    {
        parent::setUp();

        // Mengambil instance dari kontainer layanan untuk mendapatkan instance dari kelas Singleton
        $this->userService = app(UserService::class);
    }

    /** @test */
    public function it_can_register_a_user()
    {
        // Data untuk registrasi pengguna
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'role' => 'user', // Asumsikan peran default adalah 'user'
        ];

        // Register a new user using the Singleton instance
        $user = $this->userService->register($userData);

        // Assert bahwa pengguna berhasil dibuat
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }

    public function it_can_login_a_user_with_valid_credentials()
    {
        // Buat pengguna baru
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password123'), // Enkripsi password
        ]);

        // Data untuk login
        $credentials = [
            'email' => 'john@example.com',
            'password' => 'password123',
        ];

        // Coba login pengguna
        $loggedIn = $this->userService->login($credentials);

        // Pastikan pengguna berhasil login
        $this->assertTrue($loggedIn);
        $this->assertEquals(Auth::id(), $user->id);
    }

    /** @test */
    public function it_fails_to_login_a_user_with_invalid_credentials()
    {
        // Buat pengguna baru
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password123'), // Enkripsi password
        ]);

        // Data login dengan password yang salah
        $credentials = [
            'email' => 'john@example.com',
            'password' => 'wrongpassword',
        ];

        // Coba login pengguna
        $loggedIn = $this->userService->login($credentials);

        // Pastikan login gagal
        $this->assertFalse($loggedIn);
        $this->assertNull(Auth::user());
    }

    public function it_can_logout_a_user()
    {
        // Buat pengguna baru dan login
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Login pengguna
        Auth::login($user);

        // Pastikan pengguna sudah login
        $this->assertTrue(Auth::check());

        // Logout pengguna
        $this->userService->logout();

        // Pastikan pengguna sudah logout
        $this->assertFalse(Auth::check());
    }
}
