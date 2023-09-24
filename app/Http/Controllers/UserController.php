<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->userService->createUser($request->validated());

        $response = [
            'code' => 201,
            'message' => 'User added successfully',
            'data' => new UserCollection($user),
            'errors' => null
        ];

        return response()->json($response, 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        if (Auth::attempt($request->validated())) {
            $user = Auth::user();
            $user->tokens()->delete();
            $user->token = $user->createToken($user->email)->plainTextToken;

            $response = [
                'code' => 200,
                'message' => 'Login successfully',
                'data' => new UserCollection($user),
                'errors' => null
            ];

            return response()->json($response, 200);
        }

        $response = [
            'code' => 401,
            'message' => 'Incorrect login, please check your information.',
            'data' => null,
            'errors' => null
        ];

        return response()->json($response, 401);
    }
}
