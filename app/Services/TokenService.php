<?php

namespace App\Services;

use app\Webservices\N4LoginWebservice;

//use Illuminate\Contracts\Auth\UserProvider;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use App\User;

use Firebase\JWT\JWT;

class TokenService {

    public function __construct($inputKey = 'token',$storageKey = 'token')
    {
        $this->inputKey = $inputKey;
        $this->storageKey = $storageKey;
        $this->key = env('JWT_SECRET');
        $this->user = NULL;
    }

    public function createToken($user){

        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user->username, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 60*60 // Expiration time
        ];

        // As you can see we are passing `JWT_SECRET` as the second parameter that will
        // be used to decode the token in the future.
        return JWT::encode($payload, $this->key);
    }

    public function retrieveByToken($token){

        $decodedToken = $this->decodeToken($token);

        $user = new User();
        $user->username =  $decodedToken->sub;
        return $user;

    }

    public function decodeToken($token){

        if(!$token) {
            throw new \ErrorException('Token not provided.',401);
        }

        try {
            $decoded = JWT::decode($token,$this->key,['HS256']);
        }catch(\Firebase\JWT\ExpiredException $e){
            throw new \Firebase\JWT\ExpiredException('Provided token is expired.',400);
        }catch(\DomainException $e){
            throw new \DomainException('An error while decoding token.',400);
        }catch(\UnexpectedValueException $e){
             throw new \UnexpectedValueException('An error while decoding token.',400);
       }

       return $decoded;
    }



}
