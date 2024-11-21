<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckRoleAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = JWTAuth::parseToken()->authenticate();

        if($user->roles->role_name != 'ROLE_ADMIN'){
            return response()->json([
                'status'=>401,
                'error'=>'Unthorizations',
                'message'=>'Ban khong co quyen truy cap api nay',
            ], 401);
        }
        return $next($request);
    }
}
