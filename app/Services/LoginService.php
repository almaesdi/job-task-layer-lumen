<?php

namespace App\Services;

use app\Webservices\N4LoginWebservice;

use Illuminate\Contracts\Auth\UserProvider;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use app\User;

class Loginservice implements UserProvider{

    private $n4loginwebservice;

    /*public function __construct($n4loginwebservice)
    {
      $this->n4loginwebservice = $n4loginwebservice;
    }

    public function ejecutarLogin ($array){
        dd($this->n4loginwebservice->processLoginInN4($array));
    }*/

    private $model;

    protected $hasher;

    public function __construct(HasherContract $hasher, User $userModel)
    {
        $this->hasher = $hasher;
        $this->model = $userModel;
    }

    public function ejecutarLogin ($array){

    }

    public function retrieveByCredentials(array $credentials)
    {
        dd("retrieveByCredentials");
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
        //return true;
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

    public function retrieveByToken($identifier, $token) { }
    public function updateRememberToken(User $user, $token) { }
}
