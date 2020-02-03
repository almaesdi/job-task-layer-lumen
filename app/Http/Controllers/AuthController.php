<?php

namespace App\Http\Controllers;

use Validator;
use App\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request) {
        $this->request = $request;
    }

    /**
     * Authenticate a user and return the token if the provided credentials are correct.
     *
     * @param  \App\User   $user
     * @return mixed
     */
    public function authenticate() {
        /*$this->validate($this->request, [
            'email'     => 'required|email',
            'password'  => 'required'
        ]);*/

        $credentials= ['username' => $this->request['username'], 'password' => $this->request['password']];

        $user = Auth::guard('external')->attempt($credentials);

        if ($user){

            $token = Auth::createTokenByUser($user);

            return response()->json([
                'success' => [
                    'status' => 200,
                    'message' => "Your Login Was Successful.",
                    'data' => [
                        'user' => $user->username,
                        'token' => $token
                    ]
                ]
            ], 200);

        } else {
            return response()->json([
                'error' => [
                    'status' => 400,
                    'message' => "Email or password is wrong.",
                    'data' => null
                ]
            ], 400);
        }

        /*
        if (!$user) {
            // You wil probably have some sort of helpers or whatever
            // to make sure that you have the same response format for
            // differents kind of responses. But let's return the
            // below respose for now.
            return response()->json([
                'error' => 'Email does not exist.'
            ], 400);
        }

        // Verify the password and generate the token
        if (Hash::check($this->request->input('password'), $user->password)) {
            return response()->json([
                'token' => $this->jwt($user)
            ], 200);
        }

        // Bad Request response
        return response()->json([
            'error' => 'Email or password is wrong.'
        ], 400);*/
    }
}
