<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {

        $user = $this->userService->register($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Register Success',
            'data' => $user
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        if (!$this->userService->login($request->only(['email', 'password']))) {

            return response()->json([
                'status' => false,
                'message' => 'Login Failed, try again',
            ], 401);
        }

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'status' => true,
            'message' => 'Login Success',
            'token' => $user->createToken('API TOKEN')->plainTextToken,
        ], 200);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
