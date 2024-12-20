<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->authService = $authService;
    }

    public function login()
    {
        $credentials = request(['username', 'password']);
        return $this->authService->login($credentials);
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->authService->register($request);

        return response()->json([
            'status' => '201',
            'message' => 'Dang ky thanh cong',
            'data' => $user,
        ]);
    }

    public function profile()
    {
        return response()->json([
            'status' => '200',
            'message' => 'thong tin nguoi dung',
            'data' => auth('api')->user()->load('roles'),
        ]);
    }

    public function logout()
    {
        auth('api')->user();
        return response()->json(
            ['status' => 200, 'message' => 'Logout thanh cong']
        );
    }

    public function refresh()
    {
        $refreshToken = request()->refresh_token;
        return $this->authService->refreshToken($refreshToken);
    }
}
