<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\ServiceProvider;
use app\Webservices\N4LoginWebservice;
use app\Services\N4LoginService;

class N4LoginServiceProvider extends ServiceProvider
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
        //Bindeo la configuracion del webservice ESB N4 con lo del archivo
        $this->app->bind(N4LoginWebservice::class, function ($app) {
            return new N4LoginWebservice(config('webservices.tps_esb_url'),config('webservices.login_service_name'));
        });

        //Bindeo el User con el webservice de login
        $this->app->bind(N4LoginService::class, function ($app) {
            return new N4LoginService($app->make(N4LoginWebservice::class));
        });
    }
}
