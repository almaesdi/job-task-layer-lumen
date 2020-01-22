<?php

namespace App\Http\Controllers;

use App\Services\N4Loginservice;

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

    public function prueba(N4Loginservice $loginService){

        $loginService->ejecutadLogin(["username"=>"aescudero","password"=>"123123"]);

    }

    //
}
