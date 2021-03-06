<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function ($request) use ($router) {
    $router->group(['prefix' => 'polls'], function () use ($router) {
        $router->get('', 'PollController@index');
        $router->get('{id}', 'PollController@show');
        $router->get('{id}/votes', 'PollController@votes');
        $router->post('', 'PollController@store');
    });
    $router->group(['prefix' => 'votes'], function () use ($router) {
        $router->post('', 'VoteController@store');
    });
});
