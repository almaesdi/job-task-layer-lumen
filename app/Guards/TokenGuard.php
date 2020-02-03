<?php
// app/Guard/TokenGuard.php
namespace App\Guards;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\UserProvider;
use Firebase\JWT\JWT;
use \Illuminate\Contracts\Auth\Authenticatable;

use App\User;

class TokenGuard implements Guard
{
    use GuardHelpers;

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $token;

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * The name of the query string item from the request containing the API token.
     *
     * @var string
     */
    protected $inputKey;

    /**
     * The name of the token "column" in persistent storage.
     *
     * @var string
     */
    protected $storageKey;

    /**
    *
    */
    protected $tokenService;

    /**
     * Create a new authentication guard.
     *
     * @param  \Illuminate\Contracts\Auth\UserProvider  $provider
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request,$tokenService,$inputKey = 'token',$storageKey = 'token')
    {
        $this->request = $request;
        $this->tokenService = $tokenService;
        $this->inputKey = $inputKey;
        $this->storageKey = $storageKey;
        $this->key = env('JWT_SECRET');
        $this->user = NULL;
    }

    public function user()
    {
        // If we've already retrieved the user for the current request we can just
        // return it back immediately. We do not want to fetch the user data on
        // every call to this method because that would be tremendously slow.
        if (! is_null($this->user)) {
            return $this->user;
        }

        $token = $this->getTokenForRequest();

        if (! empty($token)) {
            $user = $this->tokenService->retrieveByToken($token);
        }

        return $this->user = $user;
    }

    public function getTokenForRequest()
    {
        $token = $this->request->query($this->inputKey);

        if (empty($token)) {
            $token = $this->request->header($this->inputKey,null);
        }

        if (empty($token)) {
            $token = $this->request->input($this->inputKey);
        }

        if (empty($token)) {
            $token = $this->request->bearerToken();
        }

        if (empty($token)) {
            $token = $this->request->getPassword();
        }

        return $token;
    }

    /*Metodo obligatorio de la interface */
    public function validate(array $credentials = [])
    {
        if (empty($credentials[$this->inputKey])) {
            return false;
        }

        $credentials = [$this->storageKey => $credentials[$this->inputKey]];

        if ($this->provider->retrieveByCredentials($credentials)) {
            return true;
        }

        return false;
    }


    public function createTokenByUser(User $user){

        $this->setUser($user);

        $token = $this->tokenService->createToken($user);

        return $this->token = $token;
    }

    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    public function getToken(){
        return $this->token;
    }

}
