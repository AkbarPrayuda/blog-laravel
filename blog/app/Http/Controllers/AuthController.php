<?php

namespace App\Http\Controllers;

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

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 433);
        }

        $user = $this->userService->register($request->only('name', 'email', 'password'));

        return response()->json([
            'message' => 'Berhasil Registerasi!',
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        // Login pengguna
        $loggedIn = $this->userService->login($request->only('email', 'password'));

        if ($loggedIn) {
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
