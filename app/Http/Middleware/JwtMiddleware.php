<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

use Illuminate\Support\Facades\Auth;

class JwtMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        try {
            Auth::user();
        }catch(Exception $e){
            return $this->respondeWithErrors($e->getCode(),$e->getMessage());
        }

        return $next($request);
    }

    public function respondeWithErrors($status, $message){
        return response()->json([
            'error' => [
                'status' => $status,
                'message' => $message
            ]
        ], 200);
    }

}
