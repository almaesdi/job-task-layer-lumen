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
        $token = $request->header('token',null);

        if(!$token) {
            return response()->json([
                'error' => [
                    'status' => 401,
                    'message' => 'Token not provided.'
                ]
            ], 200);
        }

        try {
            $credentials = Auth::checkToken($token);
        }catch(Exception $e){
            return response()->json([
                'error' => [
                    'status' => $e->getCode(),
                    'message' => $e->getMessage()
                ]
            ], 200);
        }

        /*$user = User::find($credentials->sub);

        // Now let's put the user in the request class so that you can grab it from there
        $request->auth = $user;*/

        return $next($request);
    }
}
