<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login()
    {
        $credentials = request(['username', 'password']);

        $token = auth('api')->attempt($credentials);

        if (!$token) {
            return response()->json(['status' => 400, 'error' => 'Unauthorized', 'message' => 'Tai khoan mat khau khong chinh xac'], 400);
        }

        $refreshToken = $this->createRefreshToken();

        return $this->respondWithToken($token, $refreshToken);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'username' => trim($request->get('username')),
            'password' => trim(Hash::make($request->get('password'))),
            'email' => trim($request->get('email')),
            'signup_device' => 'LOCAL',
            'is_enabled' => true,
            'is_confirm' => true,
            'role_id' => 1,
            'member_ship_level' => 'BASIC',
        ]);

        return response()->json([
            'status' => '201',
            'message' => 'Dang ky thanh cong',
            'data' => $user,
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

    public function profile()
    {
        return response()->json([
            'status'=>'200',
            'message'=>'thong tin nguoi dung',
            'data'=> auth()->user()->load('roles'),
        ]);
    }

    public function logout()
    {
        auth()->user();
        return response()->json(
            ['status' => 200, 'message' => 'Logout thanh cong']
        );
    }

    public function refresh()
    {
        $refreshToken = request()->refresh_token;
        try {
            $decode = JWTAuth::getJWTProvider()->decode($refreshToken);
            $user = User::find($decode['sub']);
            if (!$user) {
                return response()->json(['status' => 404, 'message' => 'Nguoi dung khong ton tai'], 404);
            }

            auth('api')->invalidate(); // vo hieu hoa token hien tai

            $token = auth()->login($user); // tao token moi
            $refreshToken = $this->createRefreshToken();

            return $this->respondWithToken($token, $refreshToken);
        } catch (Exception $ex) {
            return response()->json(['status' => 500, 'message' => 'Refresh token khong hop le'], 500);
        }
    }

    protected function respondWithToken($token, $refreshToken)
    {
        return response()->json([
            'access_token' => $token,
            'refresh_token' => $refreshToken,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60,
        ]);
    }
}
