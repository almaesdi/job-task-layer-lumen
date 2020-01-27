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

    protected $request;
    protected $user;
    protected $key;

    /**
     * The name of the token "column" in persistent storage.
     *
     * @var string
     */
    protected $storageKey;

    /**
     * Create a new authentication guard.
     *
     * @param  \Illuminate\Contracts\Auth\UserProvider  $provider
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->key = env('JWT_SECRET');
        $this->user = NULL;
    }

    public function attempt(array $credentials = [], $login = true)
    {
        dd( $this->provider->retrieveByCredentials($credentials));

        $this->lastAttempted = $user = $this->provider->retrieveByCredentials($credentials);

        if ($this->hasValidCredentials($user, $credentials)) {
            return $login ? $this->login($user) : true;
        }

        return false;
    }

    protected function hasValidCredentials($user, $credentials)
    {
        return $user !== null && $this->provider->validateCredentials($user, $credentials);
    }

    public function login(JWTSubject $user)
    {
        $token = $this->jwt->fromUser($user);
        $this->setToken($token)->setUser($user);

        return $token;
    }

    public function setToken($token)
    {
        $this->jwt->setToken($token);

        return $this;
    }

    public function user()
    {
        // If we've already retrieved the user for the current request we can just
        // return it back immediately. We do not want to fetch the user data on
        // every call to this method because that would be tremendously slow.
        if (! is_null($this->user)) {
            return $this->user;
        }

        $user = null;

        $token = $this->getTokenForRequest();

        if (! empty($token)) {
            $user = $this->provider->retrieveByCredentials([
                $this->storageKey => $this->hash ? hash('sha256', $token) : $token,
            ]);
        }

        return $this->user = $user;
    }

    public function getTokenForRequest()
    {
        $token = $this->request->query($this->inputKey);

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


    public function createToken(User $user){
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

    public function checkToken($token){

        try {
            $decoded = JWT::decode($token,$this->key,['HS256']);
        }catch(\Firebase\JWT\ExpiredException $e){
            return response()->json([
                'error' => 'Provided token is expired.'
            ], 400);
        }catch(\DomainException $e){
            return response()->json([
                'error' => 'An error while decoding token.'
            ], 400);
        }catch(\UnexpectedValueException $e){
            return response()->json([
                'error' => 'An error while decoding token.'
            ], 400);
       }

       return $decoded;

       /* if(isset($decoded) && $decoded && $decoded->sub){
            $auth = true;
        }else{
            $auth = false;
        }

        if($getIdentity){
            return $decoded;
        }

        return $auth;*/
    }

}
