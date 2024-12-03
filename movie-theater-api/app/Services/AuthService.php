<?php

namespace App\Services;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function login($credentials)
    {
        $token = auth('api')->attempt($credentials);

        if (!$token) {
            return response()->json(['status' => 400, 'error' => 'Unauthorized', 'message' => 'Tai khoan mat khau khong chinh xac'], 400);
        }

        $user = User::where('username', $credentials['username'])->first();
        $role = $user->roles->role_name;

        $refreshToken = $this->createRefreshToken();

        return $this->respondWithToken($token, $refreshToken, $role);
    }

    public function register(RegisterRequest $request)
    {
        return User::create([
            'username' => trim($request->get('username')),
            'password' => trim(Hash::make($request->get('password'))),
            'email' => trim($request->get('email')),
            'signup_device' => 'LOCAL',
            'is_enabled' => true,
            'is_confirm' => true,
            'role_id' => 1,
            'member_ship_level' => 'BASIC',
        ]);
    }

    public function createRefreshToken()
    {
        $data = [
            'sub' => auth('api')->user()->user_id,
            'random' => rand() . time(),
            'exp' => now()->addMinutes(config('jwt.ttl'))->timestamp
        ];
        $refreshToken = JWTAuth::getJWTProvider()->encode($data);
        return $refreshToken;
    }

    protected function respondWithToken($token, $refreshToken, $role)
    {
        return response()->json([
            'access_token' => $token,
            'refresh_token' => $refreshToken,
            'role' => $role,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60,
        ]);
    }

    public function refreshToken($refreshToken)
    {
        try {
            $decode = JWTAuth::getJWTProvider()->decode($refreshToken);
            $user = User::find($decode['sub']);
            if (!$user) {
                return response()->json(['status' => 404, 'message' => 'Nguoi dung khong ton tai'], 404);
            }

            auth('api')->invalidate(); // vo hieu hoa token hien tai

            $token = auth()->login($user); // tao token moi
            $refreshToken = $this->createRefreshToken();
            $role = $user->roles->role_name;

            return $this->respondWithToken($token, $refreshToken, $role);
        } catch (Exception $ex) {
            return response()->json(['status' => 500, 'message' => 'Refresh token khong hop le'], 500);
        }
    }
}
