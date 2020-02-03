<?php

namespace App\Services;

use app\Webservices\N4LoginWebservice;

use Illuminate\Contracts\Auth\UserProvider;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use app\User;

class Loginservice implements UserProvider{

    private $loginwebservice;

    private $model;

    protected $hasher;

    public function __construct(N4LoginWebservice $n4loginwebservice, HasherContract $hasher, User $userModel)
    {
        $this->loginwebservice = $n4loginwebservice;
        $this->hasher = $hasher;
        $this->model = $userModel;
    }

    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials) || (count($credentials) === 1 && array_key_exists('password', $credentials))) {
            return;
        }

        $respuesta = $this->loginwebservice->processLoginInN4($credentials);

        if($respuesta){
            $this->model = new User($respuesta);
            return $this->model;
        }

        return null;
    }

    public function retrieveById($identifier)
    {
        //$user = $this->getUserById($identifier);
        $user = session()->get($identifier);  //<---- attempted to retrieve the user, but session don't exists if I go in other route
        return $user;
        return $this->getApiUser($user);
    }

    public function validateCredentials(UserContract $user, array $credentials)
    {

        return $this->hasher->check(
            $credentials['password'], $user->getAuthPassword()
        );
    }

    protected function getApiUser($user)
    {
        if ($user !== null) {
            return new \App\ApiUser((array) $user);
        }
    }

    protected function getUserById($id)
    {
        $user = session()->get($id);
        return $user ?: null;
    }

    public function retrieveByToken($identifier, $token) {
        return null;
     }
    public function updateRememberToken(UserContract $user, $token) {
        return null;
     }
}
