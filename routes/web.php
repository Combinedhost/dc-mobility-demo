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

$router->post('/login', ['as' => 'login', 'uses' => 'AuthController@login']);
$router->post('/register', ['as' => 'register', 'uses' => 'AuthController@register']);

$router->group(['middleware' => 'check.auth'], function () use ($router) {
    $router->post('/logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);
    $router->get('/user', ['as' => 'user_index', 'uses' => 'UserController@index']);

    $router->post('/ratings', ['as' => 'post_rating', 'uses' => 'RatingController@postRating']);
    $router->get('/ratings', ['as' => 'get_user_rating', 'uses' => 'RatingController@index']);
});
