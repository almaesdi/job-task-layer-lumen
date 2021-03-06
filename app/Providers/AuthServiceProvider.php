<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

use App\Guards\ExternalLoginGuard;
use App\Guards\TokenGuard;

use Illuminate\Support\Facades\Auth;
use App\Services\Loginservice;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        //Add External Guard
        Auth::extend('web', function ($app, $name, array $config) {
            return new ExternalLoginGuard(Auth::createUserProvider($config['provider']), $app->make('request'));
        });

        //Add External Custom Provider
        Auth::provider('webservice', function ($app, array $config) {
            return new Loginservice($app->make('App\Webservices\N4LoginWebservice'), $app['hash'],$app->make('App\User'));
        });

         //Add Token Guard (local)
        Auth::extend('token', function ($app, $name, array $config) {
        return new TokenGuard($app->make('request'), $app->make('App\Services\TokenService'));
        });

       /* $this->app['auth']->viaRequest('api', function ($request) {
            if ($request->input('api_token')) {
                return User::where('api_token', $request->input('api_token'))->first();
            }
        });*/
    }
}
