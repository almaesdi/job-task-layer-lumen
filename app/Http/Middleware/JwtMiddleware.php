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
        //$token = $request->get('token');
        $token = $request->header('token',null);

        if(!$token) {
            // Unauthorized response if token not there
            return response()->json([
                'error' => 'Token not provided.'
            ], 401);
        }

        $credentials = Auth::checkToken($token);

        /*try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch(ExpiredException $e) {
            return response()->json([
                'error' => 'Provided token is expired.'
            ], 400);
        } catch(Exception $e) {
            return response()->json([
                'error' => 'An error while decoding token.'
            ], 400);
        }*/

        /*$user = User::find($credentials->sub);

        // Now let's put the user in the request class so that you can grab it from there
        $request->auth = $user;*/

        return $next($request);
    }
}
