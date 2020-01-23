<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\ServiceProvider;

use App\Webservices\N4LoginWebservice;
use Illuminate\Support\Facades\Auth;
use App\Services\Loginservice;

class N4LoginServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //Bindeo las configuraciones al webservice Login de N4
        $this->app->bind('App\Webservices\N4LoginWebservice', function ($app) {
            return new N4LoginWebservice(config('webservices.tps_esb_url'),config('webservices.login_service_name'));
        });

        //Bindeo el webservice a la capa de servicio
        /*$this->app->bind('App\Services\Loginservice', function ($app) {
            return new Loginservice($app->make('App\Webservices\N4LoginWebservice'));
        });*/

    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {


        //Bindeo el User con el webservice de login
        /*$this->app->bind(N4LoginService::class, function ($app) {
            return new N4LoginService($app->make(N4LoginWebservice::class));
        });*/
    }
}
