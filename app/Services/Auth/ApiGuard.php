<?php
// app/Services/Auth/ApiGuard.php
namespace App\Services\Auth;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;

class JsonGuard implements Guard
{
    protected $request;
    protected $provider;
    protected $user;

    /**
     * Create a new authentication guard.
     *
     * @param  \Illuminate\Contracts\Auth\UserProvider  $provider
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(UserProvider $provider, Request $request)
    {
    $this->request = $request;
    $this->provider = $provider;
    $this->user = NULL;
    }

    public function funciondeguard()
    {
      dd("funciondeguard");
    }
}
