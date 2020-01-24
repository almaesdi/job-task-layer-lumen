<?php

namespace App\Http\Controllers;

use App\Services\Loginservice;
use App\Webservices\N4LoginWebservice;

use Illuminate\Support\Facades\Auth;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function prueba(N4LoginWebservice $N4LoginWebservice){

        //$params = array(["username"=>"aescudero","password"=>"123123"]);

        dd($N4LoginWebservice->processLoginInN4(["username"=>"aescudero","password"=>"123123"]));

        //$loginService->ejecutadLogin(["username"=>"aescudero","password"=>"123123"]);

    }

    public function prueba2(){

        //$params = array(["username"=>"aescudero","password"=>"123123"]);

        //dd($Loginservice->ejecutarLogin(["username"=>"aescudero","password"=>"123123"]));

        //$loginService->ejecutadLogin(["username"=>"aescudero","password"=>"123123"]);

        //dd(Auth::attempt(['email' => "asda@asd.com", 'password' => "elterriblepass"]));
        Auth::attempt();
    }

    //
}
