<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->userService->register($request->validated());

        return response()->json([
            'message' => 'Berhasil Registerasi!',
            'user' => $user
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        // Login pengguna
        if ($this->userService->login($request->validated())) {
            return response()->json(['message' => 'User logged in successfully'], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function logout()
    {
        // Logout pengguna
        $this->userService->logout();

        return response()->json(['message' => 'User logged out successfully'], 200);
    }
}
