<?php


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return view('index');
});

$router->get('/prueba', 'ExampleController@prueba');
$router->get('/prueba2', 'ExampleController@prueba2');

$router->post('auth/login', ['uses' => 'AuthController@authenticate']);

/*$router->get('/', function () use ($router) {
    return $router->app->version();
});*/


/*Ruta para generar un APP_KEY
$router->get('/key', function() {
    return \Illuminate\Support\Str::random(32);
});*/
