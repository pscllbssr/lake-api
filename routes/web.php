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
    return env('APP_NAME');
});

$router->group(['prefix'=>'api'], function() use($router) {
    $router->get('/lakes', 'LakeController@index');
    $router->get('/lake/{key}', 'LakeController@show');
});